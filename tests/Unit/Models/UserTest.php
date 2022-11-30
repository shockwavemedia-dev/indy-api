<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Enum\UserStatusEnum;
use App\Models\User;
use App\Models\Users\AdminUser;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Models\User
 */
final class UserTest extends TestCase
{
    public function testGetterAndSetters(): void
    {
        $userType = new AdminUser();
        $userType->setAttribute('id', 1);

        $expected = [
            'id' => 1,
            'email' => 'test@test.com',
            'contact_number' => 'test',
            'gender' => 'male',
            'middle_name' => null,
            'first_name' => 'test',
            'last_name' => 'test',
            'morphable_id' => 1,
            'morphable_type' => 'App\Models\Users\AdminUser',
            'birth_date' => '1993-10-10',
            'status' => UserStatusEnum::ACTIVE,
        ];

        $user = new User();
        $user->setAttribute('id', 1);
        $user->setStatus(new UserStatusEnum(UserStatusEnum::ACTIVE));
        $user->setEmail('test@test.com');
        $user->setContactNumber('test');
        $user->setGender('male');
        $user->setMiddleName(null);
        $user->setFirstName('test');
        $user->setLastName('test');
        $user->setAttribute('morphable_id', 1); // id declared for user type
        $user->setAttribute('morphable_type', 'App\Models\Users\AdminUser');
        $user->setBirthDate(( new Carbon('1993-10-10'))->toDateString());

        $actual = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'contact_number' => $user->getContactNumber(),
            'gender' => $user->getGender(),
            'middle_name' => $user->getMiddleName(),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'morphable_id' => $user->getAttribute('morphable_id'),
            'morphable_type' => $user->getAttribute('morphable_type'),
            'birth_date' => $user->getBirthDate(),
            'status' => $user->getStatus(),
        ];

        self::assertEquals($expected, $actual);
    }
}
