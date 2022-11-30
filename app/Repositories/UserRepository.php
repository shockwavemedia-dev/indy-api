<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enum\UserStatusEnum;
use App\Models\Client;
use App\Models\User;
use App\Models\Users\AdminUser;
use App\Models\Users\ClientUser;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Users\Resources\UpdateUserResource;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

final class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new User());
    }

    public function deleteUser(User $user): void
    {
        $user->delete();
        $user->setStatus(new UserStatusEnum(UserStatusEnum::DELETED));
        $user->save();
    }

    public function findAllAdminUsers(?int $size = null, ?int $pageNumber = null): LengthAwarePaginator
    {
        return $this->model->where('morphable_type', '=', 'App\Models\Users\AdminUser')
            ->whereNotIn('id', [1])
            ->paginate($size, ['*'], null, $pageNumber);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->model->where('email', '=', $email)
                ->where('status', '<>', UserStatusEnum::DELETED)
                ->first() ?? null;
    }

    public function revoke(User $user): void
    {
        $user->setStatus(new UserStatusEnum(UserStatusEnum::REVOKED));
        $user->save();
    }

    /**
     * @throws \App\Services\Users\Exceptions\InvalidDepartmentsException
     */
    public function update(User $user, UpdateUserResource $resource): User
    {
        $user->setBirthDate($resource->getBirthDate() ?? $user->getBirthDate())
            ->setEmail($resource->getEmail())
            ->setFirstName($resource->getFirstName())
            ->setLastName($resource->getLastName())
            ->setMiddleName($resource->getMiddleName())
            ->setContactNumber($resource->getContactNumber())
            ->setStatus($resource->getStatus());

        if ($resource->getPassword() !== null) {
            $user->setPassword(Hash::make($resource->getPassword()));
        }

        if ($resource->getGender() !== null) {
            $user->setGender($resource->getGender());
        }

        $user->setAttribute('display_in_dashboard', $resource->isDisplayInDashboard());

        $userType = $user->getUserType();
        $userType->setRole($resource->getRole());

        // @Todo separate logic of updating user type and user info
        if ($userType instanceof AdminUser === true && $resource->getDepartmentId() !== null) {
            $userType->departments()->sync([$resource->getDepartmentId() => [
                'position' => $resource->getPosition(),
            ]]);
        }

        if ($resource->getProfileFile() !== null) {
            $user->setAttribute('profile_file_id', $resource->getProfileFile()->getId());
        }

        if ($userType instanceof ClientUser === true) {
            $userType->client()->associate($resource->getClient());
        }

        $userType->save();

        $user->save();

        return $user;
    }

    public function updatePassword(User $user, string $password): void
    {
        $user->setPassword($password);
        $user->setUpdatedAt(new Carbon());
        $user->save();
    }

    public function verifyUser(User $user): void
    {
        $dateToday = new Carbon();

        $user->setStatus(new UserStatusEnum(UserStatusEnum::ACTIVE));
        $user->setEmailVerifiedAt($dateToday);
        $user->setUpdatedAt($dateToday);

        $user->save();
    }

    public function findByClientUser(ClientUser $clientUser): ?User
    {
        return $this->model->where('morphable_type', '=', 'App\Models\Users\ClientUser')
            ->where('morphable_id', '=', $clientUser->getId())
            ->first() ?? null;
    }

    public function findAllClientUsersByClient(Client $client, ?int $size = null, ?int $pageNumber = null): LengthAwarePaginator
    {
        /** @var \App\Models\User $user */
        $user = $this->model;

        $userList = $user->whereHasMorph(
            'userType',
            ClientUser::class,
            function (Builder $query) use ($client) {
                $query->where('client_id', '=', $client->getId());
            }
        )->paginate($size, ['*'], null, $pageNumber);

        return $userList;
    }

    public function findByIds(array $ids): ?Collection
    {
        return $this->model->whereIn('id', $ids)->get();
    }
}
