<?php

namespace App\Http\Requests\API\Tickets;

use App\Enum\TicketAssigneeLinkIssueEnum;
use App\Enum\TicketAssigneeStatusEnum;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

final class UpdateTicketAssigneeRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getAdminUserId(): ?int
    {
        $adminUserId = $this->getInt('admin_user_id');

        if ($adminUserId === 0) {
            return null;
        }

        return $adminUserId;
    }

    public function getStatus(): TicketAssigneeStatusEnum
    {
        return new TicketAssigneeStatusEnum($this->getString('status'));
    }

    public function getLinks(): ?array
    {
        $links = $this->getArray('links');

        if (count($links) === 0) {
            return null;
        }

        return $links;
    }

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'links' => 'nullable|array',
            'links.*.ticket_assignee_id' => 'int|exists:App\Models\Tickets\TicketAssignee,id',
            'links.*.issue' => [
                'string',
                Rule::in([
                    TicketAssigneeLinkIssueEnum::BLOCKS,
                    TicketAssigneeLinkIssueEnum::BLOCKED_BY,
                ]),
            ],
            'status' => [
                'string',
                Rule::in(TicketAssigneeStatusEnum::toArray())
            ],
            'admin_user_id' => 'int|nullable|exists:App\Models\Users\AdminUser,id',
        ];
    }
}
