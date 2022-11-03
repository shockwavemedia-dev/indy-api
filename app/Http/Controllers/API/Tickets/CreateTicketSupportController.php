<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Tickets;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Tickets\CreateTicketSupportRequest;
use App\Http\Resources\API\Tickets\TicketSupportResource;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Departments\Interfaces\DepartmentTicketNotificationHandlerInterface;
use App\Services\Tickets\Exceptions\InvalidDueDateException;
use App\Services\Tickets\Interfaces\Factories\TicketTypeResolverFactoryInterface;
use App\Services\Tickets\Interfaces\Validations\DueDateValidatorInterface;
use App\Services\Tickets\Resources\CreateTicketResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class CreateTicketSupportController extends AbstractAPIController
{
    private ClientRepositoryInterface $clientRepository;

    private DepartmentRepositoryInterface $departmentRepository;

    private TicketTypeResolverFactoryInterface $factory;

    private UserRepositoryInterface $userRepository;

    public function __construct(
        ClientRepositoryInterface $clientRepository,
        DepartmentRepositoryInterface $departmentRepository,
        TicketTypeResolverFactoryInterface $factory,
        UserRepositoryInterface $userRepository
    ) {
        $this->clientRepository = $clientRepository;
        $this->departmentRepository = $departmentRepository;
        $this->factory = $factory;
        $this->userRepository = $userRepository;
    }

    public function __invoke(CreateTicketSupportRequest $request): JsonResource
    {
        try {
            $client = $this->clientRepository->find($request->getClientId());

            /** @var \App\Models\Department $department */
            $department = $this->departmentRepository->find($request->getDepartmentId());

            $requestedBy = $this->userRepository->find($request->getRequestedBy());

            $ticketCreator = $this->factory->make($request->getType());

            $ticket = $ticketCreator->create(new CreateTicketResource([
                'priority' => $request->getPriority(),
                'client' => $client,
                'createdBy' => $this->getUser(),
                'department' => $department,
                'requestedBy' => $requestedBy,
                'description' => $request->getDescription(),
                'subject' => $request->getSubject(),
                'type' => $request->getType(),
            ]));

            return new TicketSupportResource($ticket);
        } catch (InvalidDueDateException $dueDateException) {
          return $this->respondBadRequest([
              'message' => $dueDateException->getMessage()
          ]);
        } catch (Throwable $exception) {
            return $this->respondError($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
