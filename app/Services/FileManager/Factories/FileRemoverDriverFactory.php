<?php

declare(strict_types=1);

namespace App\Services\FileManager\Factories;

use App\Services\FileManager\Exceptions\FileManagerDriverNotFoundException;
use App\Services\FileManager\Interfaces\FileRemoverDriverFactoryInterface;
use App\Services\FileManager\Interfaces\FileRemoverManagerResolverInterface;
use EonX\EasyUtils\CollectorHelper;

final class FileRemoverDriverFactory implements FileRemoverDriverFactoryInterface
{
    private iterable $drivers;

    public function __construct(iterable $drivers)
    {
        $this->drivers = CollectorHelper::filterByClassAsArray(
            $drivers,
            FileRemoverManagerResolverInterface::class
        );
    }

    /**
     * @throws FileManagerDriverNotFoundException
     */
    public function make(string $manager): FileRemoverManagerResolverInterface
    {
        /** @var FileRemoverManagerResolverInterface $driver */
        foreach ($this->drivers as $driver) {
            if ($driver->supports($manager) === true) {
                return $driver;
            }
        }

        throw new FileManagerDriverNotFoundException();
    }
}
