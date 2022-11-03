<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Libraries\Factories;

use App\Models\File;
use App\Models\Library;
use App\Models\LibraryCategory;
use App\Models\User;
use App\Services\Libraries\Factories\LibraryFactory;
use App\Services\Libraries\Resources\CreateLibraryResource;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\Repositories\LibraryRepositoryStub;

/**
 * @covers \App\Services\Libraries\Factories\LibraryFactory
 */
final class LibraryFactoryTest extends TestCase
{
    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function testMakeSuccess(): void
    {
        $user = new User();
        $user->setAttribute('id', 1);

        $libraryCategory = new LibraryCategory();
        $libraryCategory->setAttribute('id', 1);

        $file = new File();
        $file->setAttribute('id', 1);

        $library = new Library();

        $resource = new CreateLibraryResource([
            'createdBy' => $user,
            'description' => 'test',
            'title' => 'test',
            'libraryCategoryId' => $libraryCategory->getId(),
            'videoLink' => 'test',
            'file' => $file,
        ]);

        $repository = new LibraryRepositoryStub([
            'create' => $library,
        ]);

        $expectedCall = [
            [
                'create' => [
                    [
                        'description' => 'test',
                        'title' => 'test',
                        'library_category_id' => 1,
                        'video_link' => 'test',
                        'file_id' => 1,
                        'created_by' => 1,
                    ],
                ],
            ],
        ];

        $factory = new LibraryFactory($repository);

        $factory->make($resource);

        $this->assertEquals($expectedCall, $repository->getCalls());
    }
}
