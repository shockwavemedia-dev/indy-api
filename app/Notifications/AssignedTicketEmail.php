<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Enum\EmailStatusEnum;
use App\Models\Emails\EmailLog;
use App\Models\Tickets\Ticket;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;

final class AssignedTicketEmail extends Notification implements ShouldQueue
{
    use Queueable;

    private EmailLog $emailLog;

    private User $createdBy;

    private User $user;

    private Ticket $ticket;

    public function __construct(
        User $user,
        Ticket $ticket,
        User $createdBy,
        EmailLog $emailLog
    ) {
        $this->user = $user->withoutRelations();

        $this->createdBy = $createdBy->withoutRelations();

        $this->ticket = $ticket->withoutRelations();

        $this->emailLog = $emailLog->withoutRelations();
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

            $url = sprintf('%s/ticket/%s', $url, $this->ticket->getId());

            $message = \sprintf(
                'Hi %s, %s has assigned Ticket #%s to you.',
                $this->user->getFirstName(),
                $this->createdBy->getFirstName(),
                $this->ticket->getTicketCode(),
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
