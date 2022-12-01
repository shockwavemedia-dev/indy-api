<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Client;
use App\Models\File;
use App\Models\Tickets\Ticket;
use App\Models\User;
use App\Repositories\Interfaces\FileRepositoryInterface;
use App\Services\Files\Resources\CreateFileResource;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

final class FileRepository extends BaseRepository implements FileRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new File());
    }

    public function deleteFile(File $file, User $user): void
    {
        $file->deletedBy()->associate($user);
        $file->delete();
        $file->save();
    }

    public function findAllByTicket(Ticket $ticket, ?int $size = null, ?int $pageNumber = null): LengthAwarePaginator
    {
        return $ticket->clientTicketFiles()->with('file')->paginate($size, ['*'], null, $pageNumber);
    }

    public function findByNameAndPath(string $filename, ?string $path = ''): ?File
    {
        return $this->model
                ->where('file_name', '=', $filename)
                ->where('file_path', '=', $path)
                ->first() ?? null;
    }

    public function incrementVersion(File $file): ?File
    {
        $file->setVersion($file->getVersion() + 1);

        $file->save();

        return $file;
    }

    public function updateBucket(File $file, string $bucket): File
    {
        $file->setBucket($bucket);
        $file->save();

        return $file;
    }

    public function updateFile(File $file, CreateFileResource $resource): File
    {
        $uploadedFile = $resource->getUploadedFile();

        $file->setFileName($resource->getFileName())
            ->setFileSize($uploadedFile->getSize())
            ->setFileType($uploadedFile->getClientMimeType())
            ->setFilePath($resource->getFilePath())
            ->setOriginalFilename($uploadedFile->getClientOriginalName())
            ->setUrlExpiration($resource->getUrlExpiration())
            ->setUrl($resource->getUrl());

        $file->setVersion($file->getVersion() + 1);

        $file->uploadedBy()->associate($resource->getUploadedBy());

        $file->save();

        return $file;
    }

    public function updateSignedUrl(File $file, string $signedUrl, ?DateTimeInterface $expiryDate = null): File
    {
        if ($expiryDate !== null) {
            $file->setUrlExpiration($expiryDate);
        }

        $file->setUrl($signedUrl);
        $file->save();

        return $file;
    }

    public function updateThumbnailUrl(File $file, string $signedUrl): File
    {
        $file->setThumbnailUrl($signedUrl);
        $file->save();

        return $file;
    }

    public function findAllByClient(Client $client): Collection
    {
        return $this->model
            ->with('clientTicketFile.ticket')
            ->whereHas('clientTicketFile', function ($query) use ($client) {
                $query->where('client_id', '=', $client->getId());
            })->get();
    }

    public function findByIds(array $ids): Collection
    {
        return $this->model->whereIn('id', $ids)->get();
    }

    public function findAllExpired(): Collection
    {
        $today = new Carbon();

        return $this->model->where('url_expiration', '<=', $today->toDateString())
            ->where('disk', 's3')
            ->get();
    }
}
