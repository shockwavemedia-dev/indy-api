<?php

namespace App\Models;

use App\Models\Traits\HasDates;
use App\Models\Traits\HasRelationshipWithUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class LibraryCategory extends AbstractModel
{
    use HasFactory, HasRelationshipWithUser, HasDates;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'slug',
        'created_by',
        'updated_by',
        'updated_at',
    ];

    protected $table = 'library_categories';

    public function getName(): string
    {
        return $this->getAttribute('name');
    }

    public function getSlug(): string
    {
        return $this->getAttribute('slug');
    }

    public function setName(string $name): string
    {
        $this->setAttribute('name', $name);

        return $this;
    }

    public function setSlug(string $slug): string
    {
        $this->setAttribute('slug', $slug);

        return $this;
    }
}
