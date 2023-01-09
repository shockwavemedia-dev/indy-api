<?php

declare(strict_types=1);

namespace App\Services\StyleGuideComments\Resources;

use App\Models\Tickets\Ticket;
use App\Models\User;
use Spatie\DataTransferObject\DataTransferObject;

final class CreateStyleGuideCommentResource extends DataTransferObject
{
    public User $user;

    public Ticket $ticket;

    public string $message;

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param  User  $user
     * @return CreateStyleGuideCommentResource
     */
    public function setUser(User $user): CreateStyleGuideCommentResource
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Ticket
     */
    public function getTicket(): Ticket
    {
        return $this->ticket;
    }

    /**
     * @param  Ticket  $ticket
     * @return CreateStyleGuideCommentResource
     */
    public function setTicket(Ticket $ticket): CreateStyleGuideCommentResource
    {
        $this->ticket = $ticket;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param  string  $message
     * @return CreateStyleGuideCommentResource
     */
    public function setMessage(string $message): CreateStyleGuideCommentResource
    {
        $this->message = $message;

        return $this;
    }
}
