<?php

declare(strict_types=1);

namespace App\Http\Resources\API\TicketAssignee;

use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\Resource;
use App\Models\Department;
use App\Models\Tickets\TicketAssignee;
use App\Models\Tickets\TicketAssigneeLink;
use function sprintf;

final class TicketAssigneeResource extends Resource
{
    public static $wrap = null;

    /**
     * @throws InvalidResourceTypeException
     */
    protected function getResponse(): array
    {
        if (($this->resource instanceof TicketAssignee) === false) {
            throw new InvalidResourceTypeException(
                TicketAssignee::class,
            );
        }

        $ticketAssignee = $this->resource;

        $adminUser = $ticketAssignee->getAdminUser();

        /** @var Department $department */
        $department = $adminUser->getDepartments()->first();

        $assigneeLinks = [];

        /** @var TicketAssigneeLink $assigneeLink */
        foreach ($ticketAssignee->getAssigneeLinks() as $assigneeLink) {
            $linkUser = $assigneeLink->getLinkAssignee()->getAdminUser();

            $linkIssue = $assigneeLink->getLinkIssue()->getOppositeLinkedIssue();

            $assigneeLinks[$linkIssue->getValue()][] = [
                'full_name' => sprintf(
                    '%s %s %s',
                    $linkUser->getUser()->getFirstName(),
                    $linkUser->getUser()->getMiddleName(),
                    $linkUser->getUser()->getLastName(),
                ),
                'status' => $assigneeLink->getLinkAssignee()->getStatus(),
                'ticket_assignee_id' => $assigneeLink->getId(),
            ];
        }

        return [
            'ticket_assignee_id' => $ticketAssignee->getId(),
            'status' => $ticketAssignee->getStatus()->getValue(),
            'admin_user_id' => $adminUser->getId(),
            'role' => $adminUser->getRole(),
            'full_name' => sprintf(
                '%s %s %s',
                $adminUser->getUser()->getFirstName(),
                $adminUser->getUser()->getMiddleName(),
                $adminUser->getUser()->getLastName(),
            ),
            'department_name' => $department?->getName(),
            'department_id' => $department?->getId(),
            'links' => $assigneeLinks,
        ];
    }
}
