<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Screens;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\PaginationRequest;
use App\Http\Resources\API\Screens\ScreensResource;
use App\Repositories\Interfaces\ScreenRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class ListScreenController extends AbstractAPIController
{
    private ScreenRepositoryInterface $screenRepository;

    public function __construct(ScreenRepositoryInterface $screenRepository)
    {
        $this->screenRepository = $screenRepository;
    }

    public function __invoke(PaginationRequest $request): JsonResource
    {
        $screens = $this->screenRepository->findAll($request->getSize(), $request->getPageNumber());

        return new ScreensResource($screens);
    }
}
