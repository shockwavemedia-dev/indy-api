<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Users;

use App\Enum\UserStatusEnum;
use App\Models\User;
use App\Models\Users\AdminUser;
use App\Services\Users\Resources\CreateUserResource;
use App\Services\Users\UserCreationService;
use function get_class;
use Illuminate\Support\Facades\Notification;
use Tests\Stubs\Repositories\UserRepositoryStub;
use Tests\Stubs\ThirdParty\Illuminate\Hashing\HasherStub;
use Tests\TestCase;

/**
 * @covers \App\Services\Users\UserCreationService
 */
final class UserCreationServiceTest extends TestCase
{
    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     * @throws \Exception
     */
    public function testCreate(): void
    {
        $user = new User();
        $user->setAttribute('id', 1);
        $user->setFirstName('test');
        $user->setMiddleName('');
        $user->setLastName('test');

        $userType = new AdminUser();
        $userType->setAttribute('id', 1);

        $token = '123456';

        $hash = new HasherStub([
            'make' => $token,
        ]);

        $userRepository = new UserRepositoryStub([
            'create' => $user,
        ]);

        $expectedCalls = [
            'hash' => [
                [
                    'make' => [
                        'password',
                    ],
                ],
            ],
            'userRepository' => [
                [
                    'create' => [
                        [
                            'morphable_id' => $userType->getId(),
                            'morphable_type' => get_class($userType),
                            'email' => 'test@testmail.com',
                            'password' => $token,
                            'status' => new UserStatusEnum(UserStatusEnum::INVITED),
                            'first_name' => 'test',
                            'middle_name' => 'test',
                            'last_name' => 'test',
                            'contact_number' => 'test',
                            'gender' => 'male',
                            'birth_date' => '2020-10-10 09:09:09',
                        ],
                    ],
                ],
            ],
        ];

        $userCreationService = new UserCreationService($userRepository, $hash);

        Notification::fake();

        $userCreationService->create(new CreateUserResource([
            'userType' => $userType,
            'email' => 'test@testmail.com',
            'password' => 'password',
            'status' => new UserStatusEnum(UserStatusEnum::INVITED),    // Default status is not verified
            'firstName' => 'test',
            'middleName' => 'test',
            'lastName' => 'test',
            'contactNumber' => 'test',
            'gender' => 'male',
            'birthDate' => '2020-10-10 09:09:09',
        ]));

        $actualCalls = [
            'hash' => $hash->getCalls(),
            'userRepository' => $userRepository->getCalls(),
        ];

        self::assertEquals($expectedCalls, $actualCalls);
    }
}
