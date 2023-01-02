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

final class TicketFileEmail extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private ClientTicketFile $ticketFile,
        private EmailLog $emailLog,
        private string $status,
        private User $user
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
            $url = Config::get('mail.client_url', null);

            if ($url === null) {
                throw new \Exception('Url for client is empty');
            }

            $url = sprintf(
                '%s/ticket/%s',
                $url,
                $this->ticketFile->getTicket()->getId()
            );

            $subject = sprintf('Ticket# %s file is %s', $this->ticketFile->getTicket()->getTicketCode(), $this->status);

            $message = \sprintf(
                'Hi %s, %s %s a file in Ticket# %s.',
                $this->user->getFirstName(),
                $this->ticketFile->getApprovedBy()->getFullName(),
                $this->status,
                $this->ticketFile->getTicket()->getTicketCode(),
            );

            $this->emailLog->setStatus(new EmailStatusEnum(EmailStatusEnum::SENT));
            $this->emailLog->save();

            return (new MailMessage)
                ->subject(__($subject))
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
