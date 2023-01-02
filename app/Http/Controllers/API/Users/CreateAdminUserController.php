<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Users;

use App\Enum\AdminRoleEnum;
use App\Enum\UserStatusEnum;
use App\Enum\UserTypeEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Users\CreateAdminUserRequest;
use App\Http\Resources\API\Users\UserResource;
use App\Jobs\File\UploadFileJob;
use App\Services\FileManager\Interfaces\BucketFactoryInterface;
use App\Services\Files\Interfaces\FileFactoryInterface;
use App\Services\Files\Resources\CreateFileResource;
use App\Services\Users\Interfaces\UserCreationServiceInterface;
use App\Services\Users\Interfaces\UserEmailVerificationResolverInterface;
use App\Services\Users\Interfaces\UserTypeFactoryResolverInterface;
use App\Services\Users\Resources\CreateAdminUserResource;
use App\Services\Users\Resources\CreateUserResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class CreateAdminUserController extends AbstractAPIController
{
    private BucketFactoryInterface $bucketFactory;

    private FileFactoryInterface $fileFactory;

    private UserEmailVerificationResolverInterface $userEmailVerificationResolver;

    private UserCreationServiceInterface $userCreationService;

    private UserTypeFactoryResolverInterface $userTypeFactory;

    public function __construct(
        BucketFactoryInterface $bucketFactory,
        FileFactoryInterface $fileFactory,
        UserCreationServiceInterface $userCreationService,
        UserEmailVerificationResolverInterface $userEmailVerificationResolver,
        UserTypeFactoryResolverInterface $userTypeFactory
    ) {
        $this->bucketFactory = $bucketFactory;
        $this->fileFactory = $fileFactory;
        $this->userEmailVerificationResolver = $userEmailVerificationResolver;
        $this->userTypeFactory = $userTypeFactory;
        $this->userCreationService = $userCreationService;
    }

    public function __invoke(CreateAdminUserRequest $request): JsonResource
    {
        try {
            $userTypeCreator = $this->userTypeFactory->make(new UserTypeEnum(UserTypeEnum::ADMIN));

            $userType = $userTypeCreator->create(new CreateAdminUserResource([
                'role' => new AdminRoleEnum($request->getRole()),
                'departmentId' => $request->getDepartmentId(),
                'position' => $request->getPosition(),
            ]));

            $file = null;

            if ($request->getProfile() !== null) {
                $bucket = $this->bucketFactory->make(self::INTERNAL_BUCKET);

                $file = $this->fileFactory->make(new CreateFileResource([
                    'uploadedFile' => $request->getProfile(),
                    'disk' => $bucket->disk(),
                    'filePath' => 'user-profile',
                    'uploadedBy' => $this->getUser(),
                    'bucket' => $bucket->name(),
                ]));

                UploadFileJob::dispatch(
                    $file->getId(),
                    \base64_encode($request->getProfile()->get()),
                );
            }

            $data = [
                'displayInDashboard' => $request->isDisplayInDashboard(),
                'profileFile' => $file,
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
