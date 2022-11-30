<?php

declare(strict_types=1);

namespace App\Services\Users;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Users\Interfaces\UserCreationServiceInterface;
use App\Services\Users\Resources\CreateUserResource;
use Illuminate\Contracts\Hashing\Hasher;

final class UserCreationService implements UserCreationServiceInterface
{
    private Hasher $hash;

    private UserRepositoryInterface $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        Hasher $hash
    ) {
        $this->hash = $hash;
        $this->userRepository = $userRepository;
    }

    /**
     * @throws \Exception
     */
    public function create(CreateUserResource $resource): User
    {
        $userType = $resource->getUserType();

        $password = null;

        if ($resource->getPassword() !== null) {
            $password = $this->hash->make($resource->getPassword());
        }

        /** @var \App\Models\User $user */
        $user = $this->userRepository->create([
            'display_in_dashboard' => $resource->isDisplayInDashboard(),
            'profile_file_id' => $resource->getProfileFile()?->getId(),
            'morphable_id' => $userType->getId(),
            'morphable_type' => \get_class($userType),
            'email' => $resource->getEmail(),
            'password' => $password,
            'status' => $resource->getStatus(),
            'first_name' => $resource->getFirstName(),
            'middle_name' => $resource->getMiddleName(),
            'last_name' => $resource->getLastName(),
            'contact_number' => $resource->getContactNumber(),
            'gender' => $resource->getGender(),
            'birth_date' => $resource->getBirthDate(),
        ]);

        return $user;
    }
}
