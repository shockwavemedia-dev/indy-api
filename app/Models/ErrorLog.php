<?php

declare(strict_types=1);

namespace App\Models;

final class ErrorLog extends AbstractModel
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'message',
        'context',
        'level',
    ];

    /**
     * @var string
     */
    protected $table = 'error_logs';
}
