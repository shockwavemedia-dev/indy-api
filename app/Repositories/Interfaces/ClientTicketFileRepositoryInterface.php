<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Tickets\ClientTicketFile;
use App\Models\User;

interface ClientTicketFileRepositoryInterface
{
    public function approve(User $user, ClientTicketFile $clientTicketFile): ClientTicketFile;

    public function deleteTicketFile(ClientTicketFile $file): void;

    public function countNewTicketFile(ClientTicketFile $file): int;
}
