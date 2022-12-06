<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Slack\Exceptions\SlackUserNullException;
use App\Services\Slack\Interfaces\SlackSendMessageInterface;
use App\Services\Slack\Interfaces\SlackUserResolverInterface;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use function sprintf;
use Throwable;

final class SendSlackNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private int $userId,
        private string $message,
    ) {
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     * @throws Exception
     */
    public function handle(
        ErrorLogInterface $sentryHandler,
        SlackUserResolverInterface $slackUserResolver,
        SlackSendMessageInterface $slackSendMessage,
        UserRepositoryInterface $userRepository
    ): void {
        $user = $userRepository->find($this->userId);

        try {
            $slackUser = $slackUserResolver->findSlackUser($user);

            $slackSendMessage->sendMessage($slackUser, $this->message);
        } catch (SlackUserNullException $nullException) {
            $sentryHandler->log(
                sprintf(
                    'This email does not have slack account %s',
                    $user->getEmail()
                )
            );
        } catch (Throwable $exception) {
            $sentryHandler->reportError($exception);
        }
    }
}
