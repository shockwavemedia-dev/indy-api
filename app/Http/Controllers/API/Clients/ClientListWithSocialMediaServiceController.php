<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Clients;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\PaginationRequest;
use App\Http\Resources\API\Clients\ClientsResource;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class ClientListWithSocialMediaServiceController extends AbstractAPIController
{
    private ClientRepositoryInterface $clientRepository;

    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function __invoke(PaginationRequest $request): JsonResource
    {
        try {
            $sortBy = $request->get('sortBy') ?? null;
            $sortOrder = $request->get('sortOrder') ?? null;

            $client = $this->clientRepository->findAllClientWithSocialMediaService(
                $request->getSize() ?? 500,
                $request->getPageNumber(),
                $sortBy,
                $sortOrder,
            );

            return new ClientsResource($client);
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage());
        }
    }
}
