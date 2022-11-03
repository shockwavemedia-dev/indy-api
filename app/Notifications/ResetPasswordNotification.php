<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Enum\EmailStatusEnum;
use App\Models\Emails\EmailLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

final class ResetPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private EmailLog $emailLog;

    public string $token;

    private string $url;

    public function __construct(EmailLog $emailLog, string $url, string $token)
    {
        $this->afterCommit();
        $this->emailLog = $emailLog->withoutRelations();
        $this->token = $token;
        $this->url = $url;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * @throws \Throwable
     */
    public function toMail($notifiable)
    {
        try {
            $url = \sprintf('%s?token=%s&email=%s', $this->url, $this->token, $notifiable->getEmailForPasswordReset());

            $this->emailLog->setStatus(new EmailStatusEnum(EmailStatusEnum::SENT));
            $this->emailLog->save();

            return (new MailMessage())
                ->subject(__('Reset Your Password!'))
                ->line(__('You are receiving this email because we received a password reset request for your account.'))
                ->action(__('Reset Password'), $url)
                ->line(__('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
                ->line(__('If you did not request a password reset, no further action is required.'));
        } catch (\Throwable $throwable) {
            $this->emailLog->setStatus(new EmailStatusEnum(EmailStatusEnum::FAILED));
            $this->emailLog->setFailedDetails($throwable->getMessage());
            $this->emailLog->save();

            throw $throwable;
        }
    }
}
