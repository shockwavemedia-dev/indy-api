<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Models\Client;
use App\Models\User;
use App\Repositories\Interfaces\ClientTicketFileRepositoryInterface;
use App\Repositories\Interfaces\FileRepositoryInterface;
use App\Services\Sorting\Interfaces\SortByYearAndMonthResolverInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class TestController extends AbstractAPIController
{

    public function __invoke(): JsonResource
    {
        $start = microtime(true);
        $user = User::find(1);
        $time = microtime(true) - $start;

        return new JsonResource([
            'time' => $time,
            'data' => $user,
        ]);
    }
}
