<?php

declare(strict_types=1);

namespace App\Notifications\PrinterJobs;

use App\Enum\EmailStatusEnum;
use App\Models\Emails\EmailLog;
use App\Models\PrinterJob;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;

final class CreatedPrinterJobForStaffEmail extends Notification implements ShouldQueue
{
    use Queueable;

    private EmailLog $emailLog;

    private User $createdBy;

    private PrinterJob $printerJob;

    public function __construct(
        PrinterJob $printerJob,
        User $createdBy,
        EmailLog $emailLog
    ) {
        $this->createdBy = $createdBy->withoutRelations();

        $this->printerJob = $printerJob->withoutRelations();

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

            $url = sprintf('%s/printer-jobs/%s', $url, $this->printerJob->getId());

            $message = \sprintf(
                'Hi %s, %s has created a printer job request #%s.',
                $notifiable->getFirstName(),
                $this->createdBy->getFirstName(),
                $this->printerJob->getId(),
            );

            $this->emailLog->setStatus(new EmailStatusEnum(EmailStatusEnum::SENT));
            $this->emailLog->save();

            return (new MailMessage)
                ->action(__('Printer Job Link'), $url)
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
        return [];
    }
}
