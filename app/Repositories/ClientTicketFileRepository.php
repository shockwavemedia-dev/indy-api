<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enum\TicketFileStatusEnum;
use App\Models\Tickets\ClientTicketFile;
use App\Models\User;
use App\Repositories\Interfaces\ClientTicketFileRepositoryInterface;
use Carbon\Carbon;

final class ClientTicketFileRepository extends BaseRepository implements ClientTicketFileRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new ClientTicketFile());
    }

    public function approve(User $user, ClientTicketFile $clientTicketFile): ClientTicketFile
    {
        $clientTicketFile->setStatus(new TicketFileStatusEnum(TicketFileStatusEnum::APPROVED));

        $clientTicketFile->approvedBy()->associate($user);

        $clientTicketFile->setApprovedAt(new Carbon());

        $clientTicketFile->save();

        return $clientTicketFile;
    }

    public function deleteTicketFile(ClientTicketFile $file): void
    {
        $file->setStatus(new TicketFileStatusEnum(TicketFileStatusEnum::DELETED));
        $file->delete();
        $file->save();
    }

    public function countNewTicketFile(ClientTicketFile $file): int
    {
        return $this->model
            ->whereHas('fileVersions', function($query) {
                $query->where('status', '=', TicketFileStatusEnum::NEW);
            })
            ->where('ticket_id', $file->getTicketId())
            ->where('status', '=', TicketFileStatusEnum::NEW)
            ->count();
    }
}
