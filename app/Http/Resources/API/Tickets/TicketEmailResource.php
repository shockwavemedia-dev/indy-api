<?php

declare(strict_types=1);

namespace App\Http\Resources\API\Tickets;

use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\Resource;
use App\Models\Tickets\TicketEmail;
use App\Models\User;

final class TicketEmailResource extends Resource
{
    /**
     * @return mixed[]
     * @throws \App\Exceptions\InvalidResourceTypeException
     */
    protected function getResponse(): array
    {
        if (($this->resource instanceof TicketEmail) === false) {
            throw new InvalidResourceTypeException(
                TicketEmail::class
            );
        }

        /** @var \App\Models\Tickets\TicketEmail $email */
        $email = $this->resource;

        /** @var User $user */
        $user = $email->getSenderBy();

        return [
            'id' => $email->getId(),
            'client_id' => $email->getClient()->getId(),
            'title' => $email->getTitle(),
            'cc' => $email->getCc() ?? null,
            'message' => $email->getMessage(),
            'sender_type' => $email->getSenderType(),
            'status' => $email->getStatus()->getValue(),
            'is_read' => $email->IsRead(),
            'sender_name' => \sprintf(
                '%s %s %s',
                $user->getFirstName(),
                $user->getMiddleName(),
                $user->getLastName(),
            ),
            'created_at' => $email->getCreatedAtAsString()
        ];
    }
}
