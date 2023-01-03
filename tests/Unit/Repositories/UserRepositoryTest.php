<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories;

use App\Enum\AdminRoleEnum;
use App\Enum\ClientRoleEnum;
use App\Enum\UserStatusEnum;
use App\Models\User;
use App\Models\Users\AdminUser;
use App\Models\Users\ClientUser;
use App\Repositories\UserRepository;
use App\Services\Users\Exceptions\InvalidDepartmentsException;
use App\Services\Users\Resources\UpdateUserResource;
use Carbon\Carbon;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Tests\TestCase;

/**
 * @covers \App\Repositories\UserRepository
 */
final class UserRepositoryTest extends TestCase
{
    public function testDeleteUser(): void
    {
        $user = $this->env->user()->user;

        $repository = new UserRepository();

        $repository->deleteUser($user);

        $user->refresh();

        $this->assertEquals(UserStatusEnum::DELETED, $user->getStatus()->getValue());
    }

    public function testFindAllAdminUsers(): void
    {
        $user = $this->env->user()->user;

        $repository = new UserRepository();

        $results = $repository->findAllAdminUsers();

        /** @var User $actual */
        $actual = $results->find($user->getId());

        $this->assertEquals($user->getId(), $actual->getId());
    }

    public function testFindByEmailSuccess(): void
    {
        $user = $this->env->user()->user;

        $repository = new UserRepository();

        $actual = $repository->findByEmail($user->getEmail());

        $this->assertEquals($user->getId(), $actual->getId());
    }

    public function testFindByEmailNull(): void
    {
        $repository = new UserRepository();

        $actual = $repository->findByEmail('unknown-email@test.com');

        $this->assertNull($actual);
    }

    public function testRevoke(): void
    {
        $user = $this->env->user()->user;

        $repository = new UserRepository();

        $repository->revoke($user);

        $user->refresh();

        self::assertEquals(UserStatusEnum::REVOKED, $user->getStatus()->getValue());
    }

    /**
     * @throws UnknownProperties
     * @throws InvalidDepartmentsException
     */
    public function testUpdateAdminUserSuccess(): void
    {
        $user = $this->env->user()->user;

        $department = $this->env->department()->department;

        $updateResource = new UpdateUserResource([
            'status' => new UserStatusEnum(UserStatusEnum::INACTIVE),
            'email' => 'test@test.com',
            'firstName' => 'test',
            'middleName' => 'test',
            'lastName' => 'test',
            'contactNumber' => 'test',
            'gender' => 'male',
            'role' => AdminRoleEnum::STAFF,
            'departmentId' => $department->getId(),
            'client' => null,
        ]);

        $repository = new UserRepository();

        $expected = [
            'status' => UserStatusEnum::INACTIVE,
            'email' => 'test@test.com',
            'firstName' => 'test',
            'middleName' => 'test',
            'lastName' => 'test',
            'contactNumber' => 'test',
            'gender' => 'male',
            'role' => AdminRoleEnum::STAFF,
            'departments' => [
                $department->getId(),
            ],
        ];

        $user = $repository->update($user, $updateResource);

        /** @var AdminUser $adminUser */
        $adminUser = $user->getUserType();

        $departments = $adminUser->getDepartments();

        $actual = [
            'status' => $user->getStatus(),
            'email' => $user->getEmail(),
            'firstName' => $user->getFirstName(),
            'middleName' => $user->getMiddleName(),
            'lastName' => $user->getLastName(),
            'contactNumber' => $user->getContactNumber(),
            'gender' => $user->getGender(),
            'role' => $user->getUserType()->getRole(),
            'departments' => [
                $departments->first()->getId(),
            ],
        ];

        self::assertEquals($expected, $actual);
    }

    /**
     * @throws UnknownProperties
     * @throws InvalidDepartmentsException
     */
    public function testUpdateClientUserSuccess(): void
    {
        $clientUser = $this->env->clientUser()->clientUser;

        $user = $this->env->user([
            'morphable_id' => $clientUser->getId(),
            'morphable_type' => \get_class($clientUser),
        ])->user;

        $client = $this->env->client()->client;

        $updateResource = new UpdateUserResource([
            'status' => new UserStatusEnum(UserStatusEnum::INACTIVE),
            'email' => 'test@test.com',
            'firstName' => 'test',
            'middleName' => 'test',
            'lastName' => 'test',
            'contactNumber' => 'test',
            'gender' => 'male',
            'role' => ClientRoleEnum::MARKETING,
            'client' => $client,
        ]);

        $repository = new UserRepository();

        $expected = [
            'status' => UserStatusEnum::INACTIVE,
            'email' => 'test@test.com',
            'firstName' => 'test',
            'middleName' => 'test',
            'lastName' => 'test',
            'contactNumber' => 'test',
            'gender' => 'male',
            'role' => ClientRoleEnum::MARKETING,
            'client_id' => $client->getId(),
        ];

        $user = $repository->update($user, $updateResource);

        $user->refresh();

        /** @var ClientUser $clientUser */
        $clientUser = $user->getUserType();

        $actual = [
            'status' => $user->getStatus()->getValue(),
            'email' => $user->getEmail(),
            'firstName' => $user->getFirstName(),
            'middleName' => $user->getMiddleName(),
            'lastName' => $user->getLastName(),
            'contactNumber' => $user->getContactNumber(),
            'gender' => $user->getGender(),
            'role' => $user->getUserType()->getRole(),
            'client_id' => $clientUser->getClient()->getId(),
        ];

        self::assertEquals($expected, $actual);
    }

    public function testUpdatePassword(): void
    {
        $user = $this->env->user()->user;

        $updatedAt = $user->getUpdatedAt();

        $repository = new UserRepository();

        $repository->updatePassword($user, 'updatePassword');

        $user->refresh();

        $this->assertNotEquals($updatedAt, $user->getUpdatedAt());
    }

    public function testVerifyUserSuccess(): void
    {
        Carbon::setTestNow(new Carbon('2020-10-10 09:09:09'));

        $user = $this->env->user()->user;

        $expected = [
            'status' => UserStatusEnum::ACTIVE,
            'email_verified_at' => '2020-10-10 09:09:09',
            'updated_at' => '2020-10-10 09:09:09',
        ];

        $repository = new UserRepository();

        $repository->verifyUser($user);

        $user->refresh();

        $actual = [
            'status' => $user->getStatus()->getValue(),
            'email_verified_at' => $user->getEmailVerifiedAt()->toDateTimeString(),
            'updated_at' => $user->getUpdatedAt()->toDateTimeString(),
        ];

        $this->assertEquals($expected, $actual);
    }

    public function testFindByClientUserSuccess(): void
    {
        $clientUser = $this->env->clientUser()->clientUser;

        $user = $this->env->user([
            'morphable_id' => $clientUser->getId(),
            'morphable_type' => \get_class($clientUser),
        ])->user;

        $repository = new UserRepository();

        $actual = $repository->findByClientUser($clientUser);

        $this->assertEquals($user->getId(), $actual->getId());
    }

    public function testFindAllClientUsersByClient(): void
    {
        $clientUser = $this->env->clientUser()->clientUser;

        $user = $this->env->user([
            'morphable_id' => $clientUser->getId(),
            'morphable_type' => \get_class($clientUser),
        ])->user;

        $repository = new UserRepository();

        $actual = $repository->findAllClientUsersByClient($clientUser->getClient());

        $actualClientUser = $actual->find($user->getId());

        $this->assertNotNull($actualClientUser);
    }
}
