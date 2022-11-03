<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Users;

use App\Enum\UserStatusEnum;
use App\Enum\UserTypeEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Users\CreateLeadClientRequest;
use App\Http\Resources\API\Users\UserResource;
use App\Services\Users\Interfaces\UserCreationServiceInterface;
use App\Services\Users\Interfaces\UserTypeFactoryResolverInterface;
use App\Services\Users\Resources\CreateLeadClientResource;
use App\Services\Users\Resources\CreateUserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

final class CreateLeadClientController extends AbstractAPIController
{
    private UserCreationServiceInterface $userCreationService;

    private UserTypeFactoryResolverInterface $userTypeFactory;

    public function __construct(
        UserCreationServiceInterface $userCreationService,
        UserTypeFactoryResolverInterface $userTypeFactory
    ) {
        $this->userCreationService = $userCreationService;
        $this->userTypeFactory = $userTypeFactory;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function __invoke(CreateLeadClientRequest $request): JsonResource
    {
        try {
            $userTypeFactory = $this->userTypeFactory->make(new UserTypeEnum(UserTypeEnum::LEAD_CLIENT));

            $userType = $userTypeFactory->create(new CreateLeadClientResource([
                'companyName' => $request->getCompanyName(),
                'fullName' => $request->getFullName(),
            ]));

            $user = $this->userCreationService->create(new CreateUserResource([
                'userType'=> $userType,
                'email' => $request->getEmail(),
                'password' => $request->getPassword(),
                'status' => new UserStatusEnum(UserStatusEnum::GUEST),    // Default status is not verified
            ]));
            // @codeCoverageIgnoreStart
        } catch (\Throwable $throwable) {
            return $this->respondError($throwable->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->respondNoContent();
    }
}
