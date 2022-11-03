<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Tickets;

use App\Enum\TicketPrioritiesEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Tickets\UpdateTicketRequest;
use App\Http\Resources\API\Tickets\TicketSupportResource;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use App\Services\Tickets\Exceptions\InvalidDueDateException;
use App\Services\Tickets\Interfaces\Validations\DueDateValidatorInterface;
use App\Services\Tickets\Resources\UpdateTicketResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;
use Symfony\Component\HttpFoundation\Response;

final class UpdateTicketController extends AbstractAPIController
{
    private DepartmentRepositoryInterface $departmentRepository;

    private DueDateValidatorInterface $dueDateValidator;

    private TicketRepositoryInterface $ticketRepository;

    public function __construct(
        DepartmentRepositoryInterface $departmentRepository,
        DueDateValidatorInterface $dueDateValidator,
        TicketRepositoryInterface $ticketRepository
    ) {
        $this->departmentRepository = $departmentRepository;
        $this->dueDateValidator = $dueDateValidator;
        $this->ticketRepository = $ticketRepository;
    }

    public function __invoke(UpdateTicketRequest $request, int $id): JsonResource
    {
        /** @var \App\Models\Tickets\Ticket $ticket */
        $ticket = $this->ticketRepository->find($id);

        if ($ticket === null) {
            return $this->respondNotFound([
                'message' => 'Ticket not found.',
            ]);
        }

        /** @var ?\App\Models\Department $department */
        $department = null;

        if ($ticket->department?->getId() !== $request->getDepartmentId()) {
            $department = $this->departmentRepository->find($request->getDepartmentId());
        }

        $department = $department ?? $ticket->department;

        /** @var \Carbon\Carbon $dueDate */
        $dueDate = $request->getDueDate();

        try {
            if ($dueDate !== null && $department !== null) {
                $this->dueDateValidator->validate(
                    $ticket->getCreatedAt(),
                    $dueDate,
                    $department?->getMinDeliveryDays() ?? 0
                );
            }

            $ticket = $this->ticketRepository->update($ticket, new UpdateTicketResource([
                'subject' => $request->getSubject() ?? $ticket->getSubject(),
                'description' => $request->getDescription() ?? $ticket->getDescription(),
                'type' => $request->getType() ?? $ticket->getType(),
                'priority' => $request->getPriority() ?? new TicketPrioritiesEnum($ticket->getPriority()),
                'dueDate' => $request->getDueDate() ?? $ticket->getDueDate(),
                'updatedBy' => $this->getUser(),
                'status' => $request->getStatus() ?? $ticket->getStatus(),
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
