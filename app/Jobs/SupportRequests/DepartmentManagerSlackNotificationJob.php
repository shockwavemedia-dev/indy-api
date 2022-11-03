<?php

declare(strict_types=1);

namespace App\Jobs\SupportRequests;

use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Models\SupportRequest;
use App\Models\User;
use App\Services\Slack\Exceptions\SlackSendMessageException;
use App\Services\Slack\Exceptions\SlackUserNullException;
use App\Services\Slack\Interfaces\SlackSendMessageInterface;
use App\Services\Slack\Interfaces\SlackUserResolverInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use function sprintf;

final class DepartmentManagerSlackNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private SupportRequest $supportRequest;

    private User $user;

    public function __construct(SupportRequest $supportRequest, User $user)
    {
        $this->supportRequest = $supportRequest;
        $this->user = $user;
    }

    public function handle(
        SlackUserResolverInterface $slackUserResolver,
        SlackSendMessageInterface $slackSendMessage,
        ErrorLogInterface $sentryHandler
    ): void {
        try {
            $slackUser = $slackUserResolver->findSlackUser($this->user);

            $message = sprintf(
                'Hi %s, Client %s has created a Support Request.',
                $slackUser->getName(),
                $this->supportRequest->getClient()->getName(),
            );

            $slackSendMessage->sendMessage($slackUser, $message);

            $sentryHandler->log($message);
        } catch (SlackUserNullException | SlackSendMessageException $exception) {
            $sentryHandler->reportError($exception);
            $sentryHandler->log(sprintf('This email does not have slack account %s',$this->user->getEmail()));
        } catch (UnknownProperties $e) {
            $sentryHandler->reportError($e);
        }
    }
}
