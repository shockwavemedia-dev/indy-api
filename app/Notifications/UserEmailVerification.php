<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Enum\EmailStatusEnum;
use App\Models\Emails\EmailLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;

final class UserEmailVerification extends Notification implements ShouldQueue
{
    use Queueable;

    private EmailLog $emailLog;

    public string $token;

    public function __construct(EmailLog $emailLog, string $token)
    {
        $this->emailLog = $emailLog->withoutRelations();
        $this->token = $token;
    }

    /**
     * @return string[]
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * @throws \Exception
     * @throws \Throwable
     */
    public function toMail($notifiable): MailMessage
    {
        try {
            $host = Config::get('mail.client_url', null);

            if ($host === null) {
                throw new \Exception('Url for client is empty');
            }

            $host = sprintf('%s/auth/account-verified', $host);

            $url = \sprintf('%s?token=%s&email=%s', $host, $this->token, $notifiable->getEmailForPasswordReset());

            $this->emailLog->setStatus(new EmailStatusEnum(EmailStatusEnum::SENT));
            $this->emailLog->save();

            return (new MailMessage())
                ->subject(__('You have been invited in Indy!'))
                ->line(__('Please check the url invitation for setting up yor account.'))
                ->action(__('Redirect'), $url)
                ->line(__('This email invite link will expire in :count minutes.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]));
        } catch (\Throwable $throwable) {
            $this->emailLog->setStatus(new EmailStatusEnum(EmailStatusEnum::FAILED));
            $this->emailLog->setFailedDetails($throwable->getMessage());
            $this->emailLog->save();

            throw $throwable;
        }
    }
}
