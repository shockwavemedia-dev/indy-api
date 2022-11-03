<?php

declare(strict_types=1);

namespace App\Models\Tickets;
use App\Models\AbstractModel;
use App\Models\File;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class FileFeedbackAttachment extends AbstractModel
{

    use SoftDeletes, HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'client_file_id',
        'feedback_id',
        'file_id'
    ];

    protected $table = 'file_feedback_attachments';

    public function getId(): int
    {
        return $this->getAttribute('id');
    }

    public function getFileId(): int
    {
        return $this->getAttribute('file_id');
    }

    public function getClientFileId(): int
    {
        return $this->getAttribute('client_file_id');
    }

    public function getFeedbackId(): int
    {
        return $this->getAttribute('feedback_id');
    }

    public function getClientTicketFile()
    {
        return $this->clientTicketFile;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function getFileFeedback()
    {
        return $this->fileFeedback;
    }

    public function getDeletedAt(): ?Carbon
    {
        return $this->getAttribute('deleted_at');
    }

    protected function clientTicketFile(): BelongsTo
    {
        return $this->belongsTo(ClientTicketFile::class, 'client_file_id');
    }

    protected function file(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_id');
    }

    protected function fileFeedback(): BelongsTo
    {
        return $this->belongsTo(FileFeedback::class, 'feedback_id');
    }
}
