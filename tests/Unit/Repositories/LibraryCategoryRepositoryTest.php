<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories;

use App\Models\Service;
use App\Repositories\LibraryCategoryRepository;
use App\Repositories\ServiceRepository;
use App\Services\LibraryCategories\Resources\CreateLibraryCategoryResource;
use Tests\TestCase;

/**
 * @covers \App\Repositories\LibraryCategoryRepository
 */
final class LibraryCategoryRepositoryTest extends TestCase
{
    public function testAll(): void
    {
        $libraryCategory = $this->env->libraryCategory()->libraryCategory;

        $repository = new LibraryCategoryRepository();

        $libraryCategories = $repository->all();

        $exist = $libraryCategories->find($libraryCategory->getId());

        self::assertNotNull($exist);
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function testUpdateSuccess(): void
    {
        $libraryCategory = $this->env->libraryCategory([
            'name' => 'test 5'
        ])->libraryCategory;

        $user = $this->env->user()->user;

        $repository = new LibraryCategoryRepository();

        $libraryCategory = $repository->update(
            $libraryCategory,
            new CreateLibraryCategoryResource([
                'name' => 'test 6',
            ]),
            $user
        );

        self::assertEquals('test 6', $libraryCategory->getName());
    }
}
