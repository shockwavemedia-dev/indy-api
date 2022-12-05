<?php

declare(strict_types=1);

namespace App\Jobs\TicketFiles;

use App\Models\Tickets\ClientTicketFile;
use App\Repositories\Interfaces\ClientTicketFileRepositoryInterface;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

final class UpdateApprovalIsRequiredJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private int $ticketFileId)
    {
    }

    /**
     * @throws UnknownProperties
     * @throws Exception
     */
    public function handle(
        ClientTicketFileRepositoryInterface $ticketFileRepository,
        TicketRepositoryInterface $ticketRepository
    ): void {
        /** @var ClientTicketFile $ticketFile */
        $ticketFile = $ticketFileRepository->find($this->ticketFileId);

        if ($ticketFile === null) {
            return;
        }

        $countNewTicketFile = $ticketFileRepository->countNewTicketFile($ticketFile);

        $hasNewFile = false;

        if ($countNewTicketFile > 0) {
            $hasNewFile = true;
        }

        $ticketRepository->updateIsApprovalRequired($ticketFile->getTicket(), $hasNewFile);
    }
}
