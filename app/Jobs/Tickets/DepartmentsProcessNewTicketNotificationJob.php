<?php

declare(strict_types=1);

namespace App\Jobs\Tickets;

use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Models\Tickets\Ticket;
use App\Models\User;
use App\Models\Users\AdminUser;
use App\Repositories\Interfaces\AdminUserRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class DepartmentsProcessNewTicketNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Collection $departments;

    private Ticket $ticket;

    public function __construct(Ticket $ticket, ?Collection $departments = null)
    {
        $this->departments = $departments ?? new Collection();
        $this->ticket = $ticket;
    }

    public function handle(
        AdminUserRepositoryInterface $adminUserRepository,
        ErrorLogInterface $errorLog
    ): void {
        $sentToUsersIds = [];

        if ($this->departments->isEmpty() === true && $this->ticket->getDepartment() === null) {
            return;
        }

        if ($this->ticket->getDepartment() !== null) {
            $this->departments->add($this->ticket->getDepartment());
        }

        foreach ($this->departments as $department) {
            $accountManagers = $adminUserRepository->findAccountManagersByDepartment($department);

            /** @var AdminUser $accountManager */
            foreach ($accountManagers as $accountManager) {
                if (in_array($accountManager->getUser()->getId(), $sentToUsersIds) === true) {
                    continue;
                }

                AccountManagerNewTicketNotificationJob::dispatch(
                    $this->ticket->getId(),
                    $accountManager->getUser()->getId()
                );

                $sentToUsersIds[] = $accountManager->getUser()->getId();
            }
        }
    }
}
