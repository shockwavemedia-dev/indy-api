<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\LibraryCategory;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Models\LibraryCategory
 */
final class LibraryCategoryTest extends TestCase
{
    public function testGetterAndSetters(): void
    {
        $expected = [
            'name' => 'test name',
            'slug' => 'test-name',
        ];

        $libraryCategory = new LibraryCategory();
        $libraryCategory->setName('test name');
        $libraryCategory->setSlug('test-name');

        $actual = [
            'name' => $libraryCategory->getName(),
            'slug' => $libraryCategory->getSlug(),
        ];

        self::assertEquals($expected, $actual);
    }
}
