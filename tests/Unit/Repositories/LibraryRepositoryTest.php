<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories;

use App\Repositories\LibraryRepository;
use App\Services\Libraries\Resources\CreateLibraryResource;
use Tests\TestCase;

/**
 * @covers \App\Repositories\LibraryRepository
 */
final class LibraryRepositoryTest extends TestCase
{
    public function testAll(): void
    {
        $library = $this->env->library()->library;

        $repository = new LibraryRepository();

        $libraries = $repository->all();

        $exist = $libraries->find($library->getId());

        self::assertNotNull($exist);
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function testUpdateSuccess(): void
    {
        $library = $this->env->library()->library;

        $libraryCategory = $this->env->libraryCategory()->libraryCategory;

        $user = $this->env->user()->user;

        $repository = new LibraryRepository();

        $file = $this->env->file()->file;

        $expected = [
            'updatedBy' => $user->getId(),
            'description' => 'test',
            'title' => 'test',
            'libraryCategoryId' => $libraryCategory->getId(),
            'videLink' => 'test',
            'file' => $file->getId(),
        ];

        $library = $repository->update($library, new CreateLibraryResource([
            'createdBy' => $user,
            'updatedBy' => $user,
            'description' => 'test',
            'title' => 'test',
            'libraryCategory' => $libraryCategory,
            'videoLink' => 'test',
            'file' => $file,
        ]));

        $actual = [
            'updatedBy' => $library->getUpdatedById(),
            'description' => $library->getDescription(),
            'title' => $library->getTitle(),
            'libraryCategoryId' => $library->getLibraryCategoryId(),
            'videLink' => $library->getVideoLink(),
            'file' => $library->getFileId(),
        ];

        self::assertEquals($expected, $actual);
    }
}
