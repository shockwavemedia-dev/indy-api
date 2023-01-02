<?php

declare(strict_types=1);

namespace App\Models\Tickets;

use App\Models\AbstractModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class FileFeedback extends AbstractModel
{
    use SoftDeletes, HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'client_file_id',
        'feedback_by',
        'feedback_by_type',
        'feedback',
    ];

    protected $table = 'file_feedbacks';

    public function getId(): int
    {
        return $this->getAttribute('id');
    }

    public function getClientTicketFile(): ClientTicketFile
    {
        return $this->clientTicketFile;
    }

    public function getClientFileId(): int
    {
        return $this->attributes('client_file_id');
    }

    public function getFeedbackBy(): User
    {
        return $this->feedbackBy;
    }

    public function getFeedbackById(): int
    {
        return $this->attributes('feedback_by');
    }

    public function getFeedbackByTypeValue(): string
    {
        return $this->attributes('feedback_by_type');
    }

    public function getFeedbackAttachments(): Collection
    {
        return $this->feedbackAttachments;
    }

    public function getFeedbackByType(): string
    {
        return $this->getAttribute('feedback_by_type');
    }

    public function getFeedback(): string
    {
        return $this->getAttribute('feedback');
    }

    public function getDeletedAt(): ?Carbon
    {
        return $this->getAttribute('deleted_at');
    }

    public function setFeedbackBy(User $user): self
    {
        $this->setAttribute('feedback_by', $user->getId());

        return $this;
    }

    public function setFeedbackByType(string $feedbackByType): self
    {
        $this->setAttribute('feedback_by_type', $feedbackByType);

        return $this;
    }

    public function setFeedback(string $message): self
    {
        $this->setAttribute('feedback', $message);

        return $this;
    }

    public function clientTicketFile(): BelongsTo
    {
        return $this->belongsTo(ClientTicketFile::class, 'client_file_id');
    }

    public function feedbackBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'feedback_by');
    }

    public function feedbackAttachments(): HasMany
    {
        return $this->hasMany(FileFeedbackAttachment::class, 'feedback_id');
    }
}
