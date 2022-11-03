<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Folders;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Folders\CreateFolderRequest;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Repositories\Interfaces\FolderRepositoryInterface;
use App\Services\Folders\Interfaces\FolderFactoryInterface;
use App\Services\Folders\Interfaces\FolderNameResolverInterface;
use App\Services\Folders\Resources\CreateFolderResource;
use App\Models\Folder;

final class CreateFolderController extends AbstractAPIController
{
    private ClientRepositoryInterface $clientRepository;

    private FolderFactoryInterface $folderFactory;

    private FolderRepositoryInterface $folderRepository;

    private FolderNameResolverInterface $folderNameResolver;

    public function __construct(
        ClientRepositoryInterface $clientRepository,
        FolderFactoryInterface $folderFactory,
        FolderRepositoryInterface $folderRepository,
        FolderNameResolverInterface $folderNameResolver,
    ) {
        $this->clientRepository = $clientRepository;
        $this->folderFactory = $folderFactory;
        $this->folderRepository = $folderRepository;
        $this->folderNameResolver = $folderNameResolver;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function __invoke(CreateFolderRequest $request, int $id)
    {
        $client = $this->clientRepository->find($id);

        if ($client === null) {
            return $this->respondNotFound([
                'message' => 'Client not found.',
            ]);
        }

        /** @var ?Folder $parentFolder */
        $parentFolder = $this->folderRepository->find($request->getParentFolderId());

        $name = $this->folderNameResolver->resolve($client, $request->getName(), $parentFolder);

        $folder = $this->folderFactory->make(new CreateFolderResource([
            'client' => $client,
            'createdBy' => $this->getUser(),
            'name' => $name,
            'parentFolder' => $parentFolder,
        ]));

        return response()->json($folder);
    }
}
