<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Commands;

use App\Http\Controllers\API\AbstractAPIController;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

final class DBSeederController extends AbstractAPIController
{
    public function __invoke(): JsonResource
    {
        if ($this->getUser()?->getEmail() !== 'superadmin@indy.com.au') {
            return $this->respondNoContent();
        }

        if (Config::get('app.demo_server') === false) {
            return $this->respondBadRequest(['message' => 'Invalid server to reset']);
        }

        Artisan::call('db:seed', [
            '--force' => true,
        ]);

        Artisan::call('files:resigned-url');

        return new JsonResource(['data' => Artisan::output()]);
    }
}
