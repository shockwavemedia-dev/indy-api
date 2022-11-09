<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Emails\Interfaces\EmailInterface;
use App\Models\Traits\HasRelationshipWithUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrinterJob extends AbstractModel implements EmailInterface
{
    use HasFactory, SoftDeletes, HasRelationshipWithUser;

    protected $casts = [
        'blind_shipping' => 'boolean',
        'reseller_samples' => 'boolean',
        'additional_options' => 'array',
    ];

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
        'purchase_order_number'
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
}
