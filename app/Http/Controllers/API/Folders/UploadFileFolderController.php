<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Folders;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Folders\UploadFileFolderRequest;
use App\Models\Folder;
use App\Repositories\Interfaces\FolderRepositoryInterface;
use App\Services\Folders\Interfaces\UploadFileFolderResolverInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class UploadFileFolderController extends AbstractAPIController
{
    private FolderRepositoryInterface $folderRepository;

    private UploadFileFolderResolverInterface $fileFolderResolver;

    public function __construct(
        FolderRepositoryInterface $folderRepository,
        UploadFileFolderResolverInterface $fileFolderResolver
    ) {
        $this->folderRepository = $folderRepository;
        $this->fileFolderResolver = $fileFolderResolver;
    }

    public function __invoke(UploadFileFolderRequest $request, int $id): JsonResource
    {
        /** @var Folder $folder */
        $folder = $this->folderRepository->find($id);

        if ($folder === null) {
            return $this->respondNotFound([
                'message' => 'Folder not found.',
            ]);
        }

        if ($this->getUser()->getUserType()->getClient()->getId() !== $folder->getClient()->getId()) {
            return $this->respondForbidden();
        }

        $this->fileFolderResolver->resolve(
            $folder,
            $this->getUser(),
            $request->getFiles()
        );

        return $this->respondNoContent();
    }
}
