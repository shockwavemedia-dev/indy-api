<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Folder extends AbstractModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'created_by',
        'name',
        'parent_folder_id',
        'updated_by',
    ];

    protected $table = 'folders';

    public function getChildFolders(): Collection
    {
        return $this->childFolders ?? new Collection();
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    public function getFiles(): Collection
    {
        return $this->files ?? new Collection();
    }

    public function getName(): string
    {
        return $this->getAttribute('name');
    }

    public function getUpdatedBy(): User
    {
        return $this->updatedBy;
    }

    public function getParentFolder(): ?Folder
    {
        return $this->parentFolder;
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function childFolders(): HasMany
    {
        return $this->hasMany(Folder::class, 'parent_folder_id');
    }

    public function parentFolder(): ?BelongsTo
    {
        return $this->belongsTo(Folder::class, 'parent_folder_id');
    }

    public function files(): HasMany
    {
        return $this->hasMany(File::class, 'folder_id');
    }
}
