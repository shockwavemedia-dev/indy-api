<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Enum\EmailStatusEnum;
use App\Models\Client;
use App\Models\Emails\EmailLog;
use App\Models\Tickets\Ticket;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;
use function sprintf;

final class NewGraphicRequestNotifyAdminEmail extends Notification implements ShouldQueue
{
    use Queueable;

    private Client $client;

    private EmailLog $emailLog;

    private Ticket $ticket;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Client $client, Ticket $ticket, EmailLog $emailLog)
    {
        $this->client = $client->withoutRelations();

        $this->emailLog = $emailLog->withoutRelations();

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
     * @throws \Exception
     * @throws \Throwable
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        try {
            $url = Config::get('mail.client_url', null);

            if ($url === null) {
                throw new Exception('Url for client is empty');
            }

            $url = sprintf('%s/ticket/%s', $url, $this->ticket->getId());

            $message = sprintf(
                'Graphic Request has been created for client %s',
                $this->client->getName(),
            );

            $this->emailLog->setStatus(new EmailStatusEnum(EmailStatusEnum::SENT));
            $this->emailLog->save();

            return (new MailMessage())
                ->action(__('Ticket link'), $url)
                ->line($message);
        } catch(\Throwable $throwable) {
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
