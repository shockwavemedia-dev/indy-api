<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Screens;

use App\Http\Controllers\API\AbstractAPIController;
use App\Repositories\Interfaces\ScreenRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class DeleteScreenController extends AbstractAPIController
{
    private ScreenRepositoryInterface $screenRepository;

    public function __construct(ScreenRepositoryInterface $screenRepository) {
        $this->screenRepository = $screenRepository;
    }

    public function __invoke(int $id): JsonResource
    {
        $screen = $this->screenRepository->find($id);

        if ($screen === null) {
            return $this->respondNoContent();
        }

        $screen->delete();
        $screen->save();

        return $this->respondNoContent();
    }
}
