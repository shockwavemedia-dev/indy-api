<?php

declare(strict_types=1);

namespace App\Models\Emails;

use App\Enum\EmailStatusEnum;
use App\Models\AbstractModel;
use App\Models\Emails\Interfaces\EmailInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class EmailLog extends AbstractModel
{
    use HasFactory, SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'morphable_id',
        'morphable_type',
        'status',
        'failed_details',
        'to',
        'cc',
        'message',
        'created_at',
    ];

    protected $table = 'email_logs';

    public function emailType(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'morphable_type', 'morphable_id');
    }

    public function getCc(): ?string
    {
        return $this->getAttribute('cc');
    }

    public function getEmailType(): EmailInterface
    {
        return $this->emailType;
    }

    public function getFailedDetails(): ?string
    {
        return $this->getAttribute('failed_details');
    }

    public function getMessage(): string
    {
        return $this->getAttribute('message');
    }

    public function getTo(): string
    {
        return $this->getAttribute('to');
    }

    public function getStatus(): EmailStatusEnum
    {
        $status = $this->getAttribute('status');

        return new EmailStatusEnum($status);
    }

    public function setFailedDetails(string $message): self
    {
        $this->setAttribute('message', $message);

        return $this;
    }

    public function setStatus(EmailStatusEnum $emailStatusEnum): self
    {
        $this->setAttribute('status', $emailStatusEnum->getValue());

        return $this;
    }
}
