<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Clients;

use App\Http\Controllers\API\AbstractAPIController;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Repositories\Interfaces\FileRepositoryInterface;
use App\Services\Sorting\Interfaces\SortByYearAndMonthResolverInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class ClientFileListController extends AbstractAPIController
{
    private ClientRepositoryInterface $clientRepository;

    private FileRepositoryInterface $fileRepository;

    private SortByYearAndMonthResolverInterface $sortByYearAndMonthResolver;

    public function __construct(
        ClientRepositoryInterface $clientRepository,
        FileRepositoryInterface $fileRepository,
        SortByYearAndMonthResolverInterface $sortByYearAndMonthResolver
    ) {
        $this->clientRepository = $clientRepository;
        $this->fileRepository = $fileRepository;
        $this->sortByYearAndMonthResolver = $sortByYearAndMonthResolver;
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

            $files = $this->fileRepository->findAllByClient($client);

            return response()->json($this->sortByYearAndMonthResolver->resolve($files));
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
