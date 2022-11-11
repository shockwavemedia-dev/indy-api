<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableInterface;

final class PrinterJobAttachment extends AbstractModel implements AuditableInterface
{
    use HasFactory, Auditable;

    protected $table = 'printer_job_attachments';

    protected $fillable = [
        'printer_job_id',
        'file_id',
        'created_at',
    ];

    public function getFile(): File
    {
        return $this->file;
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }
}
