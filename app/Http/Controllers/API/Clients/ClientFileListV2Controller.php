<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Clients;

use App\Http\Controllers\API\AbstractAPIController;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Services\Folders\Interfaces\FolderSortResolverInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class ClientFileListV2Controller extends AbstractAPIController
{
    private ClientRepositoryInterface $clientRepository;

    private FolderSortResolverInterface $folderSortResolver;

    public function __construct(
        ClientRepositoryInterface $clientRepository,
        FolderSortResolverInterface $folderSortResolver
    ) {
        $this->clientRepository = $clientRepository;
        $this->folderSortResolver = $folderSortResolver;
    }

    public function __invoke(int $id): JsonResponse|JsonResource
    {
        try {
            $client = $this->clientRepository->find($id);

            if ($client === null) {
                return $this->respondNotFound([
                    'message' => 'Client not found.',
                ]);
            }

            return response()->json($this->folderSortResolver->resolve($client));
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
