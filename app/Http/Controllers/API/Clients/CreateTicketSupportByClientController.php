<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Clients;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Clients\CreateTicketSupportByClientRequest;
use App\Http\Resources\API\Tickets\TicketSupportResource;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Tickets\Exceptions\InvalidDueDateException;
use App\Services\Tickets\Interfaces\Factories\TicketTypeResolverFactoryInterface;
use App\Services\Tickets\Interfaces\Validations\DueDateValidatorInterface;
use App\Services\Tickets\Resources\CreateTicketResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * @deprecated
 */
final class CreateTicketSupportByClientController extends AbstractAPIController
{
    private DepartmentRepositoryInterface $departmentRepository;

    private DueDateValidatorInterface $dueDateValidator;

    private TicketTypeResolverFactoryInterface $factory;

    public function __construct(
        DepartmentRepositoryInterface $departmentRepository,
        DueDateValidatorInterface $dueDateValidator,
        TicketTypeResolverFactoryInterface $factory,
        UserRepositoryInterface $userRepository
    ) {
        $this->departmentRepository = $departmentRepository;
        $this->dueDateValidator = $dueDateValidator;
        $this->factory = $factory;
    }

    public function __invoke(CreateTicketSupportByClientRequest $request): JsonResource
    {
        try {
            /** @var \App\Models\User $user */
            $user = $this->getUser();

            /** @var \App\Models\Department $department */
            $department = $this->departmentRepository->find($request->getDepartmentId());

            /** @var \Carbon\Carbon $dueDate */
            $dueDate = $request->getDueDate();

            if ($dueDate !== null) {
                $dateToday = new Carbon();

                $this->dueDateValidator->validate(
                    $dateToday,
                    $dueDate,
                    $department->getMinDeliveryDays()
                );
            }

            $ticketCreator = $this->factory->make($request->getType());

            $ticket = $ticketCreator->create(new CreateTicketResource([
                'client' => $user->getUserType()->getClient(),
                'createdBy' => $this->getUser(),
                'department' => $department,
                'requestedBy' => $user,
                'description' => $request->getDescription(),
                'dueDate' => $dueDate,
                'subject' => $request->getSubject(),
                'type' => $request->getType(),
            ]));

            return new TicketSupportResource($ticket);
        } catch (InvalidDueDateException $dueDateException) {
            return $this->respondBadRequest([
                'message' => $dueDateException->getMessage(),
            ]);
        } catch (Throwable $exception) {
            return $this->respondError($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
