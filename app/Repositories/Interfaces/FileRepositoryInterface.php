<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Client;
use App\Models\File;
use App\Models\Tickets\Ticket;
use App\Models\User;
use App\Services\Files\Resources\CreateFileResource;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface FileRepositoryInterface
{
    public function deleteFile(File $file, User $user): void;

    public function findAllByClient(Client $client): Collection;

    public function findAllByTicket(Ticket $ticket, ?int $size = null, ?int $pageNumber = null): LengthAwarePaginator;

    public function findAllExpired(): Collection;

    public function findByIds(array $ids): Collection;

    public function findByNameAndPath(string $filename, ?string $path = ''): ?File;

    public function incrementVersion(File $file): ?File;

    public function updateBucket(File $file, string $bucket): File;

    public function updateFile(File $file, CreateFileResource $resource): File;

    public function updateSignedUrl(File $file, string $signedUrl, ?DateTimeInterface $expiryDate = null): File;

    public function updateThumbnailUrl(File $file, string $signedUrl): File;
}
