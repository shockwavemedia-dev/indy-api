<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Service extends AbstractModel
{
    use HasFactory, SoftDeletes;

    /**
     * @var string[]
     */
    protected $casts = [
        'extras' => 'array',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'extras',
        'name',
    ];

    protected $table = 'services';

    public function getDepartments(): Collection
    {
        return $this->departments;
    }

    public function getExtras(): array
    {
        return $this->getAttribute('extras') ?? [];
    }

    public function getId(): int
    {
        return $this->getAttribute('id');
    }

    public function getName(): string
    {
        return $this->getAttribute('name');
    }

    /**
     * @param  string[]  $extras
     */
    public function updateExtras(array $extras): self
    {
        $this->setAttribute('extras', $extras);
        $this->save();

        return $this;
    }

    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(
            Department::class,
            Department::SERVICE_PIVOT_TABLE,
            'service_id',
            'department_id',
        );
    }
}
