<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Folders;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Folders\UpdateFolderRequest;
use App\Models\Folder;
use App\Repositories\Interfaces\FolderRepositoryInterface;
use App\Services\Folders\Interfaces\FolderNameResolverInterface;

final class UpdateFolderController extends AbstractAPIController
{
    private FolderNameResolverInterface $folderNameResolver;

    private FolderRepositoryInterface $folderRepository;

    public function __construct(
        FolderRepositoryInterface $folderRepository,
        FolderNameResolverInterface $folderNameResolver
    ) {
        $this->folderNameResolver = $folderNameResolver;
        $this->folderRepository = $folderRepository;
    }

    public function __invoke(int $id, UpdateFolderRequest $request)
    {
        /** @var Folder $folder */
        $folder = $this->folderRepository->find($id);

        if ($folder === null) {
            return $this->respondNotFound([
                'message' => 'Folder not found.',
            ]);
        }

        if ($folder->getName() === $request->getName() && $request->getParentFolderId() === null) {
            return response()->json($folder);
        }

        /** @var Folder $parentFolder */
        $parentFolder = $this->folderRepository->find($request->getParentFolderId());

        $name = $this->folderNameResolver->resolve(
            $folder->getClient(),
            $request->getName(),
            $parentFolder
        );

        $folder = $this->folderRepository->updateFolder(
            $folder,
            $this->getUser(),
            $name,
            $parentFolder
        );

        return response()->json($folder);
    }
}
