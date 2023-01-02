<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Screens;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\API\Screens\ScreenResource;
use App\Repositories\Interfaces\ScreenRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class ShowScreenController extends AbstractAPIController
{
    private ScreenRepositoryInterface $screenRepository;

    public function __construct(ScreenRepositoryInterface $screenRepository)
    {
        $this->screenRepository = $screenRepository;
    }

    public function __invoke(int $id): JsonResource
    {
        $screen = $this->screenRepository->find($id);

        if ($screen === null) {
            return $this->respondNotFound(['message' => 'Screen not found']);
        }

        return new ScreenResource($screen);
    }
}
