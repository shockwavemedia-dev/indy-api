<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Tickets\Validations;

use App\Services\Tickets\Exceptions\InvalidDueDateException;
use App\Services\Tickets\Validations\DueDateValidator;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Services\Tickets\Validations\DueDateValidator
 */
final class DueDateValidatorTest extends TestCase
{
    /**
     * @throws \App\Services\Tickets\Exceptions\InvalidDueDateException
     */
    public function testValidateEarlyReturn(): void
    {
        Carbon::setTestNow(new Carbon('2020-10-10 09:09:09'));

        $validator = new DueDateValidator();

        $result = $validator->validate(new Carbon(), new Carbon(), 0);

        self::assertTrue($result);
    }

    /**
     * @throws \App\Services\Tickets\Exceptions\InvalidDueDateException
     */
    public function testValidateSuccess(): void
    {
        Carbon::setTestNow(new Carbon('2020-10-10 09:09:09'));

        $from = new Carbon();

        $to = $from->addDays(3);

        $validator = new DueDateValidator();

        $result = $validator->validate($from, $to, 3);

        self::assertTrue($result);
    }

    /**
     * @throws \App\Services\Tickets\Exceptions\InvalidDueDateException
     */
    public function testValidateThrowInvalidDueDateException(): void
    {
        Carbon::setTestNow(new Carbon('2020-10-10 09:09:09'));

        $from = new Carbon();

        $to = (new Carbon())->addDays(1);

        $validator = new DueDateValidator();

        self::expectException(InvalidDueDateException::class);

        $validator->validate($from, $to, 3);
    }
}
