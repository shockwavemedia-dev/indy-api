<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Client;
use App\Models\MarketingPlanner;
use App\Repositories\Interfaces\MarketingPlannerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final class MarketingPlannerRepository extends BaseRepository implements  MarketingPlannerRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new MarketingPlanner());
    }

    public function findAllByClient(Client $client): Collection
    {
        return $this->model
            ->with(['attachments.file', 'createdBy', 'updatedBy', 'client', 'tasks.assignees'])
            ->where('client_id', '=', $client->getId())
            ->get();
    }

    public function updateMarketingPlanner(
        MarketingPlanner $marketingPlanner,
        array $changes
    ): MarketingPlanner {
        $this->model->where('id', '=', $marketingPlanner->getId())
            ->update($changes);

        $marketingPlanner->refresh();

        return $marketingPlanner;
    }
}
