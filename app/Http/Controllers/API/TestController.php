<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Benchmark;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

final class TestController extends AbstractAPIController
{
    public function __invoke(): JsonResource
    {
        $start = microtime(true);
        $user = User::find(1);
        $time = microtime(true) - $start;

        $value = Cache::get('key', function () {
            return DB::table('users')->get();
        });

        Benchmark::dd([
            'Scenario 1' => fn () => $value,
            'Scenario 2' => fn () => 'Test',
        ]);

        return new JsonResource([
            'time' => $time,
            'data' => $user,
        ]);
    }
}
