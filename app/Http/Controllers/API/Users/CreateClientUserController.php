<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Users;

use App\Enum\ClientRoleEnum;
use App\Enum\UserStatusEnum;
use App\Enum\UserTypeEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Users\CreateClientUserRequest;
use App\Http\Resources\API\Users\UserResource;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Services\Users\Interfaces\UserCreationServiceInterface;
use App\Services\Users\Interfaces\UserEmailVerificationResolverInterface;
use App\Services\Users\Interfaces\UserTypeFactoryResolverInterface;
use App\Services\Users\Resources\CreateClientUserResource;
use App\Services\Users\Resources\CreateUserResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class CreateClientUserController extends AbstractAPIController
{
    private ClientRepositoryInterface $clientRepository;

    private UserCreationServiceInterface $userCreationService;

    private UserTypeFactoryResolverInterface $userTypeFactory;

    private UserEmailVerificationResolverInterface $userEmailVerificationResolver;

    public function __construct(
        ClientRepositoryInterface $clientRepository,
        UserCreationServiceInterface $userCreationService,
        UserTypeFactoryResolverInterface $userTypeFactory,
        UserEmailVerificationResolverInterface $userEmailVerificationResolver
    ) {
        $this->clientRepository = $clientRepository;
        $this->userTypeFactory = $userTypeFactory;
        $this->userCreationService = $userCreationService;
        $this->userEmailVerificationResolver = $userEmailVerificationResolver;
    }

    public function __invoke(CreateClientUserRequest $request): JsonResource
    {
        try {
            $userTypeCreator = $this->userTypeFactory->make(new UserTypeEnum(UserTypeEnum::CLIENT));

            $client = $this->clientRepository->find($request->getClientId());

            $userType = $userTypeCreator->create(new CreateClientUserResource([
                'role' => new ClientRoleEnum($request->getRole()),
                'client' => $client,
            ]));

            $data = [
                'userType' => $userType,
                'email' => $request->getEmail(),
                'status' => new UserStatusEnum(UserStatusEnum::INVITED),    // Default status is not verified
                'firstName' => $request->getFirstName(),
                'middleName' => $request->getMiddleName(),
                'lastName' => $request->getLastName(),
                'contactNumber' => $request->getContactNumber(),
                'gender' => $request->getGender(),
                'birthDate' => (new Carbon($request->getBirthDate()))->toDateString(),
            ];

            if ($request->get('send_invite') === 0 || $request->get('send_invite') === false) {
                $data['password'] = $request->getPassword();
                $data['status'] = new UserStatusEnum(UserStatusEnum::ACTIVE);
            }

            $user = $this->userCreationService->create(new CreateUserResource($data));

            if ($request->get('send_invite') === 1 || $request->get('send_invite') === true) {
                $this->userEmailVerificationResolver->resolve($user);
            }

            return new UserResource($user);
            // @codeCoverageIgnoreStart
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        // @codeCoverageIgnoreEnd
    }
}
