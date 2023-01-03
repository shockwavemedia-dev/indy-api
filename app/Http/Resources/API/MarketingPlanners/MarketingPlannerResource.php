<?php

declare(strict_types=1);

namespace App\Http\Resources\API\MarketingPlanners;

use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\Resource;
use App\Models\MarketingPlanner;
use function sprintf;

final class MarketingPlannerResource extends Resource
{
    public static $wrap = null;

    /**
     * @throws \App\Exceptions\InvalidResourceTypeException
     */
    protected function getResponse(): array
    {
        if (($this->resource instanceof MarketingPlanner) === false) {
            throw new InvalidResourceTypeException(
                MarketingPlanner::class
            );
        }

        /** @var \App\Models\MarketingPlanner $marketingPlanner */
        $marketingPlanner = $this->resource;

        return [
            'id' => $marketingPlanner->getId(),
            'event_name' => $marketingPlanner->getEventName(),
            'description' => $marketingPlanner->getDescription(),
            'todo_list' => new MarketingPlannerTasksResource($marketingPlanner->getTasks()),
            'start_date' => $marketingPlanner->getStartDateAsString(),
            'end_date' => $marketingPlanner->getEndDateAsString(),
            'is_recurring' => $marketingPlanner->isRecurring(),
            'created_by' => sprintf(
                '%s %s %s',
                $marketingPlanner->getCreatedBy()->getFirstName(),
                $marketingPlanner->getCreatedBy()->getMiddleName(),
                $marketingPlanner->getCreatedBy()->getLastName(),
            ),
            'updated_by' => sprintf(
                '%s %s %s',
                $marketingPlanner->getUpdatedBy()?->getFirstName(),
                $marketingPlanner->getCreatedBy()?->getMiddleName(),
                $marketingPlanner->getCreatedBy()?->getLastName(),
            ),
            'updated_at' => $marketingPlanner->getUpdatedAtAsString(),
            'created_at' => $marketingPlanner->getCreatedAtAsString(),
            'attachments' => new FilesResource($marketingPlanner->getAttachments()),
        ];
    }
}
