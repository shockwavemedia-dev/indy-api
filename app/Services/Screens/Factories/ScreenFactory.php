<?php

declare(strict_types=1);

namespace App\Services\Screens\Factories;

use App\Models\Screen;
use App\Repositories\Interfaces\ScreenRepositoryInterface;
use App\Services\Screens\Interfaces\ScreenFactoryInterface;
use App\Services\Screens\Resources\CreateScreenResource;

final class ScreenFactory implements ScreenFactoryInterface
{
    private ScreenRepositoryInterface $screenRepository;

    public function __construct(ScreenRepositoryInterface $screenRepository) {
        $this->screenRepository = $screenRepository;
    }

    public function make(CreateScreenResource $screenResource): Screen
    {
        /** @var Screen $screen */
        $screen = $this->screenRepository->create([
            'name' => $screenResource->getName(),
            'slug' => $screenResource->getSlug(),
            'logo_file_id' => $screenResource->getLogoFileId(),
            'created_by' => $screenResource->getCreatedBy()->getId(),
        ]);

        return $screen;
    }
}
