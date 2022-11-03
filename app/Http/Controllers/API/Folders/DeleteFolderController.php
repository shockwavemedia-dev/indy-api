<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Folders;

use App\Http\Controllers\API\AbstractAPIController;
use App\Models\Folder;
use App\Repositories\Interfaces\FolderRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class DeleteFolderController extends AbstractAPIController
{
    private FolderRepositoryInterface $folderRepository;

    public function __construct(FolderRepositoryInterface $folderRepository)
    {
        $this->folderRepository = $folderRepository;
    }

    public function __invoke(int $id): JsonResource
    {
        /** @var Folder $folder */
        $folder = $this->folderRepository->find($id);

        if ($folder === null) {
            return $this->respondNoContent();
        }

        if (
            $folder->getFiles()->isEmpty() === true &&
            $folder->getChildFolders()->isEmpty() === true
        ) {
            $this->folderRepository->deleteFolder($folder, $this->getUser());

            return $this->respondNoContent();
        }

        return $this->respondBadRequest([
            'message' => 'Unable to delete folder that contain file(s) or folder(s).',
        ]);
    }
}
