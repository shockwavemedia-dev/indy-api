<?php

declare(strict_types=1);

namespace App\Http\Requests\API\Tickets;

use App\Enum\TicketAssigneeLinkIssueEnum;
use App\Enum\TicketAssigneeStatusEnum;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

final class TicketAssignStaffsRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getAdminUserId(): int
    {
        return $this->getInt('admin_user_id');
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
            'admin_user_id' => 'required|int|exists:App\Models\Users\AdminUser,id',
            'links' => 'nullable|array',
            'links.*.ticket_assignee_id' => 'int|exists:App\Models\Tickets\TicketAssignee,id',
            'links.*.issue' => [
                'string',
                Rule::in([
                    TicketAssigneeLinkIssueEnum::BLOCKS,
                    TicketAssigneeLinkIssueEnum::BLOCKED_BY,
                ]),
            ],
        ];
    }

}
