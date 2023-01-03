<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Enum\EmailStatusEnum;
use App\Models\Emails\EmailLog;
use App\Models\Tickets\ClientTicketFile;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;

final class SocialMediaFileUploadedEmail extends Notification implements ShouldQueue
{
    use Queueable;

    private EmailLog $emailLog;

    private User $user;

    private ClientTicketFile $ticketFile;

    public function __construct(
        ClientTicketFile $ticketFile,
        EmailLog $emailLog,
        User $user
    ) {
        $this->ticketFile = $ticketFile;
        $this->emailLog = $emailLog->withoutRelations();
        $this->user = $user->withoutRelations();
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
            $url = Config::get('mail.client_url', null);

            if ($url === null) {
                throw new \Exception('Url for client is empty');
            }

            $url = sprintf(
                '%s/ticket/%s',
                $url,
                $this->ticketFile->getTicket()->getId()
            );

            $message = \sprintf(
                'Hi %s, %s Uploaded a file in Ticket# %s with Social Media Service.',
                $this->user->getFirstName(),
                $this->ticketFile->getFile()->getUploadedBy()->getFullName(),
                $this->ticketFile->getTicket()->getTicketCode(),
            );

            $this->emailLog->setStatus(new EmailStatusEnum(EmailStatusEnum::SENT));
            $this->emailLog->save();

            return (new MailMessage)
                ->action(__('Ticket link'), $url)
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
