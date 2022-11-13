<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Emails\Interfaces\EmailInterface;
use App\Models\Traits\HasRelationshipWithUser;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableInterface;

class PrinterJob extends AbstractModel implements EmailInterface, AuditableInterface
{
    use HasFactory, SoftDeletes, HasRelationshipWithUser, Auditable;

    protected $fillable = [
        'client_id',
        'printer_id',
        'status',
        'customer_name',
        'product',
        'option',
        'kinds',
        'quantity',
        'run_ons',
        'format',
        'final_trim_size',
        'reference',
        'notes',
        'additional_options',
        'delivery',
        'price',
        'blind_shipping',
        'reseller_samples',
        'created_by',
        'stocks',
        'coding',
        'address',
        'purchase_order_number',
        'description'
    ];

    protected $table = 'printer_jobs';

    public function getPrinter(): Printer
    {
        return $this->printer;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function printer(): BelongsTo
    {
        return $this->belongsTo(Printer::class);
    }

    public function getAttachments(): ?Collection
    {
        return $this->attachments;
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(PrinterJobAttachment::class, 'printer_job_id');
    }
}
