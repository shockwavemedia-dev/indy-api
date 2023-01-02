<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Libraries;

use App\Enum\ServicesEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Libraries\ClientCreateLibraryTicketRequest;
use App\Http\Resources\API\Tickets\TicketSupportResource;
use App\Models\Library;
use App\Repositories\Interfaces\LibraryRepositoryInterface;
use App\Services\Libraries\Interfaces\Factories\LibraryTicketEventFactoryInterface;
use App\Services\Libraries\Resources\CreateLibraryTicketEventResource;
use App\Services\TicketAssignee\Interfaces\DesignatorResolverFactoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class ClientCreateLibraryTicketController extends AbstractAPIController
{
    public function __construct(
        private DesignatorResolverFactoryInterface $designatorResolverFactory,
        private LibraryRepositoryInterface $libraryRepository,
        private LibraryTicketEventFactoryInterface $libraryTicketEventFactory
    ) {
        $this->libraryRepository = $libraryRepository;
        $this->libraryTicketEventFactory = $libraryTicketEventFactory;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function __invoke(ClientCreateLibraryTicketRequest $request, int $id): JsonResource
    {
        try {
            /** @var Library $library */
            $library = $this->libraryRepository->find($id);

            if ($library === null) {
                return $this->respondNotFound([
                    'message' => 'Library not found.',
                ]);
            }

            /** @var \App\Models\User $user */
            $user = $this->getUser();

            /** @var \App\Models\Users\ClientUser $clientUser */
            $clientUser = $user->getUserType();

            $ticket = $this->libraryTicketEventFactory->make(new CreateLibraryTicketEventResource([
                'clientUser' => $clientUser,
                'description' => $request->getDescription(),
                'libraryId' => $library->getId(),
            ]));

            $designatorResolver = $this->designatorResolverFactory->make(ServicesEnum::from(ServicesEnum::ANIMATION));

            $designatorResolver->resolve($ticket);

            return new TicketSupportResource($ticket);
        } catch (\Throwable $throwable) {
            return $this->respondInternalError([
                'message' => $throwable->getMessage(),
            ]);
        }
    }
}
