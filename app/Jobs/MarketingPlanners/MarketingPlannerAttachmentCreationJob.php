<?php

declare(strict_types=1);

namespace App\Jobs\MarketingPlanners;

use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Repositories\Interfaces\FileRepositoryInterface;
use App\Repositories\Interfaces\MarketingPlannerRepositoryInterface;
use App\Services\MarketingPlanners\Interfaces\MarketingPlannerAttachmentFactoryInterface;
use App\Services\MarketingPlanners\Resources\MarketingPlannerAttachmentCreateResource;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

final class MarketingPlannerAttachmentCreationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $fileId;

    private int $marketingPlannerId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $fileId, int $marketingPlannerId)
    {
        $this->fileId = $fileId;
        $this->marketingPlannerId = $marketingPlannerId;
    }

    public function handle(
        MarketingPlannerRepositoryInterface $marketingPlannerRepository,
        FileRepositoryInterface $fileRepository,
        MarketingPlannerAttachmentFactoryInterface $marketingPlannerAttachmentFactory,
        ErrorLogInterface $sentryHandler
    ): void {
        try {
            $file = $fileRepository->find($this->fileId);
            $marketingPlanner = $marketingPlannerRepository->find($this->marketingPlannerId);

            $marketingPlannerAttachmentFactory->make(new MarketingPlannerAttachmentCreateResource([
                'file' => $file,
                'marketingPlanner' => $marketingPlanner,
            ]));
        } catch (Throwable $exception) {
            $sentryHandler->reportError($exception);
        }
    }
}
