<?php

declare(strict_types=1);

namespace App\Models;

use App\Enum\UserStatusEnum;
use App\Models\Emails\EmailLog;
use App\Models\Emails\Interfaces\EmailInterface;
use App\Models\Tickets\ClientTicketFile;
use App\Models\Tickets\Ticket;
use App\Models\Tickets\TicketEmail;
use App\Models\Users\Interfaces\UserTypeInterface;
use App\Notifications\AssignedTicketEmail;
use App\Notifications\NewGraphicRequestNotifyAdminEmail;
use App\Notifications\PrinterJobs\AssignedPriceToPrinterJobEmail;
use App\Notifications\PrinterJobs\CreatedPrinterJobForStaffEmail;
use App\Notifications\PrinterJobs\UpdateStatusPrinterJobEmail;
use App\Notifications\SendTicketEmail;
use App\Notifications\SocialMediaFileUploadedEmail;
use App\Notifications\SocialMediaMentionEmail;
use App\Notifications\SocialMediaTicketFileApprovedEmail;
use App\Notifications\SupportRequestAccountManagerEmail;
use App\Notifications\TicketCreatedEmail;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;
use Laravel\Passport\HasApiTokens;
use Exception;

final class User extends Authenticatable implements EmailInterface
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'morphable_id',
        'morphable_type',
        'password',
        'status',
        'first_name',
        'middle_name',
        'last_name',
        'contact_number',
        'gender',
        'birth_date',
        'profile_file_id',
        'display_in_dashboard',
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $table = 'users';

    /**
     * @var string[]
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'deleted_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function assignedTicket(Ticket $ticket, User $createdBy, EmailLog $emailLog): void
    {
        $this->notify(new AssignedTicketEmail($this, $ticket, $createdBy, $emailLog));
    }

    public function sendEmailToAccountManager(Ticket $ticket,  EmailLog $emailLog): void
    {
        $this->notify(new TicketCreatedEmail($this, $ticket, $emailLog));
    }

    public function sendEmailToMentionedSocialMediaUser(
        SocialMedia $socialMedia,
        User $mentionedBy,
        EmailLog $emailLog
    ): void {
        $this->notify(new SocialMediaMentionEmail($socialMedia, $this, $mentionedBy, $emailLog));
    }

    public function sendEmailToPrinter(
        PrinterJob $printerJob,
        EmailLog $emailLog,
        User $createdBy,
    ): void {
        $this->notify(new CreatedPrinterJobForStaffEmail($printerJob, $createdBy, $emailLog));
    }

    public function sendEmailPriceOfferToClient(
        PrinterJob $printerJob,
        EmailLog $emailLog,
     ): void {
        $this->notify(new AssignedPriceToPrinterJobEmail($printerJob, $emailLog));
    }

    public function sendEmailPrinterJobUpdateStatusToClient(
        PrinterJob $printerJob,
        EmailLog $emailLog,
    ): void {
        $this->notify(new UpdateStatusPrinterJobEmail($printerJob, $emailLog));
    }

    public function getBirthDate(): ?string
    {
        return $this->getAttribute('birth_date');
    }

    public function getContactNumber(): ?string
    {
        return $this->getAttribute('contact_number');
    }

    public function getEmail(): string
    {
        return $this->getAttribute('email');
    }

    public function getEmailVerifiedAt(): Carbon
    {
        return $this->getAttribute('email_verified_at');
    }

    public function getFirstName(): string
    {
        return $this->getAttribute('first_name');
    }

    public function getFullName(): string
    {
        return \sprintf(
            '%s %s %s',
            $this->getFirstName(),
            $this->getMiddleName(),
            $this->getLastName()
        );
    }

    public function getGender()
    {
        return $this->getAttribute('gender');
    }

    public function getId(): int
    {
        return $this->getAttribute('id');
    }

    public function getLastName(): ?string
    {
        return $this->getAttribute('last_name');
    }

    public function getMiddleName(): ?string
    {
        return $this->getAttribute('middle_name');
    }

    public function isDisplayInDashboard(): bool
    {
        return $this->getAttribute('display_in_dashboard');
    }

    public function getStatus(): UserStatusEnum
    {
        $status = $this->getAttribute('status');

        return new UserStatusEnum($status);
    }

    public function getUpdatedAt(): ?Carbon
    {
        return $this->getAttribute('updated_at');
    }

    public function getUserType(): UserTypeInterface
    {
        return $this->userType;
    }

    public function notifyNewCreatedGraphicTicket(Client $client, Ticket $ticket, EmailLog $emailLog): void
    {
        $this->notify(new NewGraphicRequestNotifyAdminEmail($client, $ticket, $emailLog));
    }

    public function notifySocialMediaForFileUploaded(ClientTicketFile $clientTicketFile, EmailLog $emailLog): void
    {
        $this->notify(new SocialMediaFileUploadedEmail($clientTicketFile, $emailLog, $this));
    }

    public function notifySocialMediaForFileApproved(ClientTicketFile $clientTicketFile, EmailLog $emailLog): void
    {
        $this->notify(new SocialMediaTicketFileApprovedEmail($clientTicketFile, $emailLog, $this));
    }

    /**
     * @throws \Exception
     */
    public function resetPassword(string $token): void
    {
        $url = Config::get('mail.client_url', null);

        if ($url === null) {
            throw new Exception('Url in resetting password is empty');
        }

        $url = sprintf('%s/auth/password-reset',$url);

//        $this->notify((new ResetPasswordNotification($url, $token)));
    }

    public function setBirthDate(string $birthDate): self
    {
        $this->setAttribute('birth_date', $birthDate);

        return $this;
    }

    public function setContactNumber(?string $contactNumber = null): self
    {
        $this->setAttribute('contact_number', $contactNumber);

        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->setAttribute('email', $email);

        return $this;
    }

    public function setEmailVerifiedAt(DateTimeInterface $date): self
    {
        $this->setAttribute('email_verified_at', $date);

        return $this;
    }

    public function setFirstName(string $firstName): self
    {
        $this->setAttribute('first_name', $firstName);

        return $this;
    }

    public function setGender(string $gender): self
    {
        $this->setAttribute('gender', $gender);

        return $this;
    }

    public function setLastName(string $lastName): self
    {
        $this->setAttribute('last_name', $lastName);

        return $this;
    }

    public function setMiddleName(?string $middleName): self
    {
        $this->setAttribute('middle_name', $middleName);

        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->setAttribute('password', $password);

        return $this;
    }

    public function setStatus(UserStatusEnum $status): self
    {
        $this->setAttribute('status', $status->getValue());

        return $this;
    }

    public function userType(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'morphable_type', 'morphable_id');
    }

    private function attributes(string $field)
    {
        return $this->attributes[$field] ?? null;
    }

    public function sendTicketEmail(TicketEmail $ticketEmail, Ticket $ticket): void
    {
        $this->notify(new SendTicketEmail($this, $ticketEmail, $ticket ));
    }

    public function sendEmailForSupportRequest(EmailLog $emailLog, SupportRequest $supportRequest): void
    {
        $this->notify(new SupportRequestAccountManagerEmail($emailLog, $supportRequest));
    }

    public function getProfileFile(): ?File
    {
        return $this->profileFile;
    }

    public function profileFile(): BelongsTo
    {
        return $this->belongsTo(File::class, 'profile_file_id');
    }
}
