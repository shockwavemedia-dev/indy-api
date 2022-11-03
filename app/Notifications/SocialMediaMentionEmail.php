<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Enum\EmailStatusEnum;
use App\Models\Emails\EmailLog;
use App\Models\SocialMedia;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

final class SocialMediaMentionEmail extends Notification implements ShouldQueue
{
    use Queueable;

    private EmailLog $emailLog;

    private User $mentionedBy;

    private User $user;

    private SocialMedia $socialMedia;

    public function __construct(
        SocialMedia $socialMedia,
        User $user,
        User $mentionedBy,
        EmailLog $emailLog
    ) {
        $this->user = $user->withoutRelations();
        $this->socialMedia = $socialMedia;
        $this->mentionedBy = $mentionedBy;
        $this->emailLog = $emailLog->withoutRelations();
    }

    /**
     * @param mixed $notifiable
     * @return string[]
     */
    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     * @throws \Exception
     * @throws \Throwable
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        try {
            $message = \sprintf(
                'Hi %s, You have been mentioned by %s in a comment in social media %s',
                $this->user->getFirstName(),
                $this->mentionedBy->getFirstName(),
                $this->socialMedia->getPost(),
            );

            $this->emailLog->setStatus(new EmailStatusEnum(EmailStatusEnum::SENT));
            $this->emailLog->save();

            return (new MailMessage)
                ->line($message);
        } catch (\Throwable $exception) {
            $this->emailLog->setStatus(new EmailStatusEnum(EmailStatusEnum::FAILED));
            $this->emailLog->setFailedDetails($exception->getMessage());
            $this->emailLog->save();

            throw $exception;
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return string[]
     */
    public function toArray(mixed $notifiable): array
    {
        return [
            //
        ];
    }
}
