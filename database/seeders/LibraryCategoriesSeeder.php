<?php

namespace Database\Seeders;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\LibraryCategories\Interfaces\LibraryCategoryFactoryInterface;
use App\Services\LibraryCategories\Resources\CreateLibraryCategoryResource;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class LibraryCategoriesSeeder extends Seeder
{
    private LibraryCategoryFactoryInterface $categoryFactory;

    private UserRepositoryInterface $userRepository;

    public function __construct(
        LibraryCategoryFactoryInterface $categoryFactory,
        UserRepositoryInterface $userRepository
    ) {
        $this->categoryFactory = $categoryFactory;
        $this->userRepository = $userRepository;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function run(): void
    {
        $user = $this->userRepository->findByEmail('superadmin@dailypress.com');

        if ($user === null) {
            return;
        }

        $libraryCategories = [
            0 => [
                'id' => 1,
                'name' => 'AFL',
                'slug' => 'afl',
            ],
            1 => [
                'id' => 2,
                'name' => 'Anzac Day',
                'slug' => 'anzac-day',
            ],
            2 => [
                'id' => 3,
                'name' => 'App',
                'slug' => 'app',
            ],
            3 => [
                'id' => 4,
                'name' => 'Australia Day',
                'slug' => 'australia-day',
            ],
            4 => [
                'id' => 5,
                'name' => 'Beer Promos',
                'slug' => 'beer-promos',
            ],
            5 => [
                'id' => 6,
                'name' => 'Bingo',
                'slug' => 'bingo',
            ],
            6 => [
                'id' => 7,
                'name' => 'Birthday',
                'slug' => 'birthday',
            ],
            7 => [
                'id' => 8,
                'name' => 'Body Heat',
                'slug' => 'body-heat',
            ],
            8 => [
                'id' => 9,
                'name' => 'Boxing',
                'slug' => 'boxing',
            ],
            9 => [
                'id' => 10,
                'name' => 'Car Promotions',
                'slug' => 'car-promotions',
            ],
            10 => [
                'id' => 11,
                'name' => 'Christmas in July',
                'slug' => 'christmas-in-july',
            ],
            11 => [
                'id' => 12,
                'name' => 'Christmas Promo',
                'slug' => 'christmas-promo',
            ],
            12 => [
                'id' => 13,
                'name' => 'Christmas Raffle',
                'slug' => 'christmas-raffle',
            ],
            13 => [
                'id' => 14,
                'name' => 'Club Safe',
                'slug' => 'club-safe',
            ],
            14 => [
                'id' => 15,
                'name' => 'Courtesy Bus',
                'slug' => 'courtesy-bus',
            ],
        ];

        foreach ($libraryCategories as $libraryCategory) {
            $this->categoryFactory->make(
                $user,
                new CreateLibraryCategoryResource([
                    'name' => Arr::get($libraryCategory, 'name'),
                    'slug' => Arr::get($libraryCategory, 'slug'),
                ])
            );
        }
    }
}
