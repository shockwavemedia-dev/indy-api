<?php

declare(strict_types=1);

namespace Tests\Stubs\Repositories;

use App\Models\Client;
use App\Models\File;
use App\Models\Tickets\Ticket;
use App\Models\User;
use App\Repositories\Interfaces\FileRepositoryInterface;
use App\Services\Files\Resources\CreateFileResource;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class FileRepositoryStub extends AbstractStub implements FileRepositoryInterface
{
    /**
     * @throws \Throwable
     */
    public function deleteFile(File $file, User $user): void
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function findAllByClient(Client $client): Collection
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function findByNameAndPath(string $filename, ?string $path = ''): ?File
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function incrementVersion(File $file): ?File
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function updateBucket(File $file, string $bucket): File
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function updateFile(File $file, CreateFileResource $resource): File
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function updateSignedUrl(File $file, string $signedUrl, ?DateTimeInterface $expiryDate = null): File
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function findAllByTicket(Ticket $ticket, ?int $size = null, ?int $pageNumber = null): LengthAwarePaginator
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function updateThumbnailUrl(File $file, string $signedUrl): File
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function findByIds(array $ids): Collection
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function findAllExpired(): Collection
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }
}
