<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Sorting;

use App\Services\Sorting\SortByYearAndMonthResolver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

/**
 * @covers \App\Services\Sorting\SortByYearAndMonthResolver
 */
final class SortByYearAndMonthResolverTest extends TestCase
{
    public function testResolveSuccess(): void
    {
        Carbon::setTestNow(new Carbon('2020-10-10 09:09:09'));

        $year2020 = new Carbon();

        Carbon::setTestNow(new Carbon('2021-10-10 09:09:09'));

        $year2021 = new Carbon();

        $resolver = new SortByYearAndMonthResolver();

        $data = new Collection();

        $file1 = $this->env->file()->file;

        $file2 = $this->env->file()->file;

        $data->add($file1);
        $data->add($file2);

        $result = $resolver->resolve($data);

        self::assertArrayHasKey('2021', $result);
    }
}
