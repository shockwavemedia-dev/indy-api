<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Tickets\ClientTicketFile;
use App\Models\Tickets\FileFeedback;
use App\Repositories\Interfaces\FileFeedbackRepositoryInterface;
use App\Services\FileFeedbacks\Resources\UpdateFileFeedbackResource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class FileFeedbackRepository extends BaseRepository implements FileFeedbackRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new FileFeedback());
    }

    public function findByClientTicketFile(
        ClientTicketFile $clientTicketFile,
        ?int $size = null,
        ?int $pageNumber = null
    ): LengthAwarePaginator {
        return $this->model
            ->where('client_file_id', $clientTicketFile->getId())
            ->with('feedbackAttachments')
            ->paginate(
                $size,
                ['*'],
                null,
                $pageNumber
            );
    }

    public function update(FileFeedback $fileFeedback, UpdateFileFeedbackResource $resource): FileFeedback
    {
        $fileFeedback->setFeedback($resource->getFeedback());

        $fileFeedback->save();

        return $fileFeedback;
    }

    public function deleteFileFeedback(FileFeedback $fileFeedback): void
    {
        $fileFeedback->delete();
        $fileFeedback->save();
    }
}
