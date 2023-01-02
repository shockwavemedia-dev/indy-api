<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Enum\EmailStatusEnum;
use App\Models\Emails\EmailLog;
use App\Models\SupportRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use function sprintf;
use Throwable;

final class SupportRequestAccountManagerEmail extends Notification implements ShouldQueue
{
    use Queueable;

    private EmailLog $emailLog;

    private SupportRequest $supportRequest;

    public function __construct(
        EmailLog $emailLog,
        SupportRequest $supportRequest
    ) {
        $this->emailLog = $emailLog->withoutRelations();
        $this->supportRequest = $supportRequest;
    }

    /**
     * @return string[]
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * @throws \App\Notifications\Exception
     * @throws \Throwable
     */
    public function toMail($notifiable): MailMessage
    {
        try {
            $clientName = $this->supportRequest->getClient()->getName();

            $subject = sprintf('Support request from %s', $clientName);

            $message = $this->supportRequest->getMessage();

            $user = $this->supportRequest->getCreatedBy();

            $messageIntro = sprintf('%s created a support request.', $user->getFirstName());

            $this->emailLog->setStatus(new EmailStatusEnum(EmailStatusEnum::SENT));
            $this->emailLog->save();

            return (new MailMessage())
                ->subject(__($subject))
                ->line(__($messageIntro))
                ->line(__($message));
        } catch (Throwable $throwable) {
            $this->emailLog->setStatus(new EmailStatusEnum(EmailStatusEnum::FAILED));
            $this->emailLog->setFailedDetails($throwable->getMessage());
            $this->emailLog->save();

            throw $throwable;
        }
    }
}
