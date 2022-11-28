<?php

declare(strict_types=1);

namespace App\Http\Resources\API\Users;

use App\Enum\UserTypeEnum;
use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\Resource;
use App\Models\User;
use App\Models\Users\AdminUser;

final class UserResource extends Resource
{
    public static $wrap = null;

    /**
     * @return mixed[]
     *
     * @throws InvalidResourceTypeException
     */
    protected function getResponse(): array
    {
        if (($this->resource instanceof User) === false) {
            throw new InvalidResourceTypeException(
                User::class
            );
        }

        /** @var User $user */
        $user = $this->resource;

        $userType = $user->getUserType();

        $result = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'status' => $user->getStatus()->getValue(),
            'full_name' => \sprintf(
                '%s %s %s',
                $user->getFirstName(),
                $user->getMiddleName(),
                $user->getLastName(),
            ),
            'first_name' => $user->getFirstName(),
            'middle_name' => $user->getMiddleName(),
            'last_name' => $user->getLastName(),
            'contact_number' => $user->getContactNumber(),
            'gender' => $user->getGender(),
            'birth_date' => $user->getBirthDate(),
            'user_type' => new UserTypeResource($userType),
            'profile_file' => $user->getProfileFile(),
        ];

        /** @var AdminUser $userType */
        if ($userType->getType()->getValue() === UserTypeEnum::ADMIN) {
            $result['open_tickets'] = $userType->getOpenTickets();
            $result['closed_tickets_30'] = $userType->getClosedTicketsBy30Days();
            $result['closed_tickets_90'] = $userType->getClosedTicketsBy90Days();
        }

        return $result;
    }
}
