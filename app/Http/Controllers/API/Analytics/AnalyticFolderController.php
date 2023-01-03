<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Analytics;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Analytics\AnalyticQueryRequest;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Repositories\Interfaces\FolderRepositoryInterface;
use App\Services\Folders\Interfaces\FolderFactoryInterface;
use App\Services\Folders\Resources\CreateFolderResource;
use App\Services\Sorting\Interfaces\SortByYearAndMonthResolverInterface;
use Illuminate\Http\JsonResponse;

final class AnalyticFolderController extends AbstractAPIController
{
    private ClientRepositoryInterface $clientRepository;

    private FolderFactoryInterface $folderFactory;

    private FolderRepositoryInterface $folderRepository;

    private SortByYearAndMonthResolverInterface $sortByYearAndMonthResolver;

    public function __construct(
        ClientRepositoryInterface $clientRepository,
        FolderFactoryInterface $folderFactory,
        FolderRepositoryInterface $folderRepository,
        SortByYearAndMonthResolverInterface $sortByYearAndMonthResolver
    ) {
        $this->clientRepository = $clientRepository;
        $this->folderFactory = $folderFactory;
        $this->folderRepository = $folderRepository;
        $this->sortByYearAndMonthResolver = $sortByYearAndMonthResolver;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function __invoke(AnalyticQueryRequest $request, int $id)
    {
        $client = $this->clientRepository->find($id);

        if ($client === null) {
            return $this->respondNotFound([
                'message' => 'Client not found.',
            ]);
        }

        if ($client->getId() !== $this->getUser()->getUserType()->getClient()->getId()) {
            return $this->respondForbidden();
        }

        $menuName = $request->getMenu() ?? 'Data Analytics';

        $folder = $this->folderRepository->findByClientAndName($client, $menuName);

        if ($folder === null) {
            $folder = $this->folderFactory->make(new CreateFolderResource([
                'client' => $client,
                'createdBy' => $this->getUser(),
                'name' => $menuName,
            ]));
        }

        $data[$folder->getName()] = [
            'id' => $folder->getId(),
            'name' => $folder->getName(),
            'files' => $this->sortByYearAndMonthResolver->resolve($client, $folder->getFiles()),
        ];

        return new JsonResponse($data);
    }
}
