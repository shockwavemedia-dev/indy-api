<?php

declare(strict_types=1);

namespace App\Jobs\SocialMedia;

use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Models\SocialMedia;
use App\Repositories\Interfaces\SocialMediaRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
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

final class MentionedSlackNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $userId;

    private int $mentionedById;

    private int $socialMediaId;

    public function __construct(
        int $mentionedById,
        int $userId,
        int $socialMediaId
    ) {
        $this->mentionedById = $mentionedById;
        $this->userId = $userId;
        $this->socialMediaId = $socialMediaId;
    }

    /**
     * @throws \Exception
     */
    public function handle(
        UserRepositoryInterface $userRepository,
        SocialMediaRepositoryInterface $socialMediaRepository,
        SlackUserResolverInterface $slackUserResolver,
        SlackSendMessageInterface $slackSendMessage,
        ErrorLogInterface $sentryHandler
    ): void {
        $user = $userRepository->find($this->userId);

        try {
            $slackUser = $slackUserResolver->findSlackUser($user);

            $mentionedBy = $userRepository->find($this->mentionedById);

            /** @var SocialMedia $socialMedia */
            $socialMedia = $socialMediaRepository->find($this->socialMediaId);

            $message = \sprintf(
                'Hi %s, You have been mentioned by %s in a comment in social media %s',
                $user->getFirstName(),
                $mentionedBy->getFirstName(),
                $socialMedia->getPost(),
            );

            $slackSendMessage->sendMessage(
                $slackUser,
                $message,
            );

            $sentryHandler->log($message);
        } catch (SlackUserNullException|SlackSendMessageException $exception) {
            $sentryHandler->log(
                sprintf(
                    'This email does not have slack account %s',
                    $user->getEmail()
                )
            );
        } catch (UnknownProperties $e) {
            $sentryHandler->reportError($e);
        }
    }
}
