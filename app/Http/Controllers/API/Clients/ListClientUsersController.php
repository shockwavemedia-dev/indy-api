<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Clients;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\PaginationRequest;
use App\Http\Resources\API\Users\UserAdminsResource;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class ListClientUsersController extends AbstractAPIController
{
    private ClientRepositoryInterface $clientRepository;

    private UserRepositoryInterface $userRepository;

    public function __construct(
        ClientRepositoryInterface $clientRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->clientRepository = $clientRepository;
        $this->userRepository = $userRepository;
    }

    public function __invoke(PaginationRequest $request, int $id): JsonResource
    {
        try {
            $client = $this->clientRepository->find($id);

            if ($client === null) {
                return $this->respondNotFound([
                    'message' => 'Client not found.',
                ]);
            }

            $users = $this->userRepository->findAllClientUsersByClient(
                $client,
                $request->getSize(),
                $request->getPageNumber()
            );

            return new UserAdminsResource($users);
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage());
        }
    }
}
