<?php

declare(strict_types=1);

namespace App\Http\Resources\API\Tickets;

use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\API\TicketAssignee\TicketAssigneeResource;
use App\Http\Resources\Resource;
use App\Models\Tickets\Ticket;
use App\Models\Tickets\TicketService;
use Illuminate\Support\Arr;

final class TicketSupportResource extends Resource
{
    private ?array $services = null;

    public static $wrap = null;

    public function __construct($resource, ?array $services = null)
    {
        $this->services = $services;

        parent::__construct($resource);
    }

    /**
     * @throws InvalidResourceTypeException
     */
    protected function getResponse(): array
    {
        if (($this->resource instanceof Ticket) === false) {
            throw new InvalidResourceTypeException(
                Ticket::class
            );
        }

        /** @var Ticket $ticket */
        $ticket = $this->resource;

        $emailHtml = null;

        if ($ticket->getAttribute('email_html') !== null) {
            $emailHtml = json_decode($ticket->getAttribute('email_html'));

            $emailHtml = $emailHtml?->data;
        }

        $userNotes = [];

        foreach ($ticket->getUserNotes() as $userId => $value) {
            $userNotes[$userId] = $value;
        }

        $result = [
            'id' => $ticket->getId(),
            'is_overdue' => $ticket->isOverdue(),
            'ticket_code' => $ticket->getTicketCode(),
            'client_id' => $ticket->getClientId(),
            'client_name' => $ticket->getClient()?->getName(),
            'subject' => $ticket->getSubject(),
            'description' => $ticket->getDescription() ?? '{"blocks":[{"key":"a7itc","text":"","type":"unstyled","depth":0,"inlineStyleRanges":[],"entityRanges":[],"data":{}}],"entityMap":{}}',
            'department_name' => $ticket->getDepartment()?->getName(),
            'priority' => $ticket->getPriority(),
            'duedate' => $ticket->getDueDate()?->toDateString(),
            'type' => $ticket->getType()->getValue(),
            'status' => $ticket->getStatus()->getValue(),
            'email_html' => $emailHtml,
            'created_at' => $ticket->getCreatedAtAsString(),
            'user_notes' => json_encode($userNotes),
            'client_logo' => $ticket->getClient()->getLogo(),
            'is_approval_required' => $ticket->isApprovalRequired(),
        ];

        $assignees = [];

        foreach ($ticket->getTicketAssignees() as $ticketAssignee) {
            $assignees[] = new TicketAssigneeResource($ticketAssignee);
        }

        $result['assignees'] = $assignees;

        if ($ticket->getTicketEvent() !== null) {
            $ticketEvent = $ticket->getTicketEvent();

            $result['attachments'] = new TicketsEventAttachmentsResource($ticketEvent?->getAttachments());
        }

        /** @var TicketService $ticketService */
        foreach ($ticket->getTicketServices() as $ticketService) {
            $serviceTemp['service_name'] = $ticketService->getService()->getName();
            $serviceTemp['service_id'] = $ticketService->getService()->getId();
            $serviceTemp['extras'] = $ticketService->getExtras();
            $serviceTemp['custom_fields'] = $ticketService->getCustomFields();
            $serviceTemp['updated_extras'] = $ticketService->getExtras();
            $result['services'][] = $serviceTemp;
        }

        if ($this->services !== null) {
            foreach ($this->services as $service) {
                $serviceId = Arr::get($service, 'service_id');

                if ($serviceId === null) {
                    continue;
                }

                $serviceTemp['service_id'] = (int) $serviceId;
                $serviceTemp['extras'] = Arr::get($service, 'extras');
                $result['services'][] = $serviceTemp;
            }
        }

        return $result;
    }
}
