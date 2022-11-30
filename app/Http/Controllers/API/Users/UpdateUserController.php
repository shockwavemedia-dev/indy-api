<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Users;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Users\UpdateUserRequest;
use App\Http\Resources\API\Users\UserResource;
use App\Jobs\File\UploadFileJob;
use App\Models\User;
use App\Models\Users\LeadClient;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\FileManager\Interfaces\BucketFactoryInterface;
use App\Services\Files\Interfaces\FileFactoryInterface;
use App\Services\Files\Resources\CreateFileResource;
use App\Services\Users\Resources\UpdateUserResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class UpdateUserController extends AbstractAPIController
{
    private BucketFactoryInterface $bucketFactory;

    private FileFactoryInterface $fileFactory;

    private ClientRepositoryInterface $clientRepository;

    private UserRepositoryInterface $userRepository;

    public function __construct(
        BucketFactoryInterface $bucketFactory,
        FileFactoryInterface $fileFactory,
        ClientRepositoryInterface $clientRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->bucketFactory = $bucketFactory;
        $this->fileFactory = $fileFactory;
        $this->clientRepository = $clientRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     * @throws \App\Services\FileManager\Exceptions\BucketNameExistsException
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function __invoke(UpdateUserRequest $request, int $id): JsonResource
    {
        /** @var User $user */
        $user = $this->userRepository->find($id);

        if ($user === null) {
            return $this->respondNotFound([
                'message' => 'User not found.',
            ]);
        }

        if ($user->getUserType() instanceof LeadClient === true) {
            return $this->respondUnauthorised([
                'message' => 'User is a lead client, cant be updated.',
            ]);
        }

        if (\count($request->all()) === 0) {
            return new UserResource($user);
        }

        $clientId = $request->getClientId();

        $client = null;

        if ($clientId !== null) {
            $client = $this->clientRepository->find($clientId);
        }

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

        try {
            //@TODO validation if there is update needed if not return early.
            $user = $this->userRepository->update($user, new UpdateUserResource([
                'profileFile' => $file,
                'password' => $request->getPassword(),
                'display_in_dashboard' => $request->isDisplayInDashboard(),
                'status' => $request->getStatus() ?? $user->getStatus(),
                'email' => $request->getEmail() ?? $user->getEmail(),
                'firstName' => $request->getFirstName() ?? $user->getFirstName(),
                'middleName' => $request->getMiddleName() ?? $user->getMiddleName(),
                'lastName' => $request->getLastName() ?? $user->getLastName() ?? '',
                'contactNumber' => $request->getContactNumber() ?? $user->getContactNumber() ?? '',
                'gender' => $request->getGender() ?? $user->getGender(),
                'birthDate' => ($request->getBirthDate() !== null) ?
                    (new Carbon($request->getBirthDate()))->toDateString()
                    : (new Carbon($user->getBirthDate()))->toDateString(),
                'role' => $request->getRole() ?? $user->getUserType()->getRole(),
                'departmentId' => $request->getDepartmentId(),
                'client' => $client,
                'position' => $request->getPosition(),
            ]));

            return new UserResource($user);
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
