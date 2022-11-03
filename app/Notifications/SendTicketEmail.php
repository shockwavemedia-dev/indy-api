<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Enum\EmailStatusEnum;
use App\Models\Emails\EmailLog;
use App\Models\Tickets\Ticket;
use App\Models\Tickets\TicketEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use function sprintf;
use Throwable;

final class SendTicketEmail extends Notification implements ShouldQueue
{
    use Queueable;

    private EmailLog $emailLog;

    private TicketEmail $ticketEmail;

    private Ticket $ticket;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(TicketEmail $ticketEmail, Ticket $ticket, EmailLog $emailLog)
    {
        $this->emailLog = $emailLog->withoutRelations();

        $this->ticketEmail = $ticketEmail->withoutRelations();

        $this->ticket = $ticket->withoutRelations();
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @throws \Throwable
     */
    public function toMail($notifiable): MailMessage
    {
        try {
            $subject = sprintf(
                'Ticket #%s Email',
                $this->ticket->getTicketCode(),
            );

            $mail = (new MailMessage())
                ->subject(__($subject))
                ->line(__($this->ticketEmail->getMessage()));

            if ($this->ticketEmail->getCc() !== null) {
                $mail->cc(__($this->ticketEmail->getCc()));
            }

            $this->emailLog->setStatus(new EmailStatusEnum(EmailStatusEnum::SENT));
            $this->emailLog->save();

            return $mail;
        } catch (Throwable $throwable) {
            $this->emailLog->setStatus(new EmailStatusEnum(EmailStatusEnum::FAILED));
            $this->emailLog->setFailedDetails($throwable->getMessage());
            $this->emailLog->save();

            throw $throwable;
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
        ];
    }
}
