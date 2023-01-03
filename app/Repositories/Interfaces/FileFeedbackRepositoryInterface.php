<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Tickets\ClientTicketFile;
use App\Models\Tickets\FileFeedback;
use App\Services\FileFeedbacks\Resources\UpdateFileFeedbackResource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface FileFeedbackRepositoryInterface
{
    public function findByClientTicketFile(
        ClientTicketFile $clientTicketFile,
        ?int $size = null,
        ?int $pageNumber = null
    ): LengthAwarePaginator;

    public function update(FileFeedback $fileFeedback, UpdateFileFeedbackResource $resource): FileFeedback;

    public function deleteFileFeedback(FileFeedback $fileFeedback): void;
}
