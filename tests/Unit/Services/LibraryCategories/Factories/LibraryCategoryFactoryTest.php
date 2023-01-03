<?php

declare(strict_types=1);

namespace Tests\Unit\Services\LibraryCategories\Factories;

use App\Models\LibraryCategory;
use App\Models\User;
use App\Services\LibraryCategories\Factories\LibraryCategoryFactory;
use App\Services\LibraryCategories\Resources\CreateLibraryCategoryResource;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\Repositories\LibraryCategoryRepositoryStub;

/**
 * @covers \App\Services\LibraryCategories\Factories\LibraryCategoryFactory
 */
final class LibraryCategoryFactoryTest extends TestCase
{
    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function testMakeSuccess(): void
    {
        $user = new User();
        $user->setAttribute('id', 1);

        $libraryCategory = new LibraryCategory();

        $resource = new CreateLibraryCategoryResource([
            'name' => 'test name',
        ]);

        $repository = new LibraryCategoryRepositoryStub([
            'create' => $libraryCategory,
            'findByName' => null,
        ]);

        $expectedCall = [
            [
                'findByName' => [
                    'test name',
                ],
            ],
            [
                'create' => [
                    [
                        'name' => 'test name',
                        'slug' => 'test-name',
                        'created_by' => 1,
                    ],
                ],
            ],
        ];

        $factory = new LibraryCategoryFactory($repository);

        $factory->make($user, $resource);

        $this->assertEquals($expectedCall, $repository->getCalls());
    }
}
