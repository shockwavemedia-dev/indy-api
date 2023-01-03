<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Tickets;

use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\PaginationRequest;
use App\Http\Resources\API\Tickets\TicketSupportsResource;
use App\Models\Users\AdminUser;
use App\Repositories\Interfaces\AdminUserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;

final class ShowTicketsByAdminUserController extends AbstractAPIController
{
    private AdminUserRepositoryInterface $adminUserRepository;

    private ErrorLogInterface $errorLog;

    public function __construct(AdminUserRepositoryInterface $adminUserRepository, ErrorLogInterface $errorLog)
    {
        $this->adminUserRepository = $adminUserRepository;
        $this->errorLog = $errorLog;
    }

    public function __invoke(PaginationRequest $request, int $id): JsonResource
    {
        /** @var AdminUser $adminUser */
        $adminUser = $this->adminUserRepository->find($id);

        if ($adminUser === null) {
            return $this->respondNotFound([
                'message' => 'Admin User Not found.',
            ]);
        }

        $tickets = new Collection();

        foreach ($adminUser->getTickets() as $ticketAssignee) {
            if ($ticketAssignee->getTicket() === null) {
                $this->errorLog->log(json_encode($ticketAssignee));

                continue;
            }

            $tickets->add($ticketAssignee->getTicket());
        }

        return new TicketSupportsResource(
            $tickets->paginate(
                $request->getSize(),
                null,
                $request->getPageNumber(),
            )
        );
    }
}
