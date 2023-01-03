<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Library;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Models\Library
 */
final class LibraryTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $expected = [
            'description' => 'test',
            'title' => 'test',
            'video_link' => 'test',
        ];

        $library = new Library();
        $library->setDescription('test');
        $library->setTitle('test');
        $library->setVideoLink('test');

        $actual = [
            'description' => $library->getDescription(),
            'title' => $library->getTitle(),
            'video_link' => $library->getVideoLink(),
        ];

        $this->assertEquals($expected, $actual);
    }
}
