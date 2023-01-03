<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Enum\EmailStatusEnum;
use App\Models\Emails\EmailLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

final class GenericEmail extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private EmailLog $emailLog,
        private string $message,
        private string $link,
        private string $subject,
    ) {
    }

    /**
     * @param  mixed  $notifiable
     * @return string[]
     */
    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     *
     * @throws \Exception
     * @throws \Throwable
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        try {
            $this->emailLog->setStatus(new EmailStatusEnum(EmailStatusEnum::SENT));
            $this->emailLog->save();

            return (new MailMessage)
                ->subject($this->subject)
                ->action(__('Link'), $this->link)
                ->line($this->message);
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
