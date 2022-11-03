<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\SupportRequests;

use App\Enum\BackendUserNotificationTypeEnum;
use App\Enum\SupportRequestStatusEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\SupportRequests\CreateSupportRequestRequest;
use App\Models\User;
use App\Models\Users\ClientUser;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Services\BackendUserNotifications\Interfaces\BackendUserNotificationResolverFactoryInterface;
use App\Services\SupportRequests\Interfaces\SupportRequestFactoryInterface;
use App\Services\SupportRequests\Resources\CreateSupportRequestResource;
use Illuminate\Http\Resources\Json\JsonResource;

final class CreateSupportRequestController extends AbstractAPIController
{
    private BackendUserNotificationResolverFactoryInterface $backendUserNotificationResolverFactory;

    private DepartmentRepositoryInterface $departmentRepository;

    private SupportRequestFactoryInterface $supportRequestFactory;

    public function __construct(
        BackendUserNotificationResolverFactoryInterface $backendUserNotificationResolverFactory,
        DepartmentRepositoryInterface $departmentRepository,
        SupportRequestFactoryInterface $supportRequestFactory
    ) {
        $this->backendUserNotificationResolverFactory = $backendUserNotificationResolverFactory;
        $this->departmentRepository = $departmentRepository;
        $this->supportRequestFactory = $supportRequestFactory;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function __invoke(CreateSupportRequestRequest $request): JsonResource
    {
        $department = $this->departmentRepository->find($request->getDepartmentId());

        /** @var User $user */
        $user = $this->getUser();

        /** @var ClientUser $clientUser */
        $clientUser = $user->getUserType();

        $supportRequest = $this->supportRequestFactory->make(new CreateSupportRequestResource([
            'department' => $department,
            'createdBy' => $user,
            'client' => $clientUser->getClient(),
            'message' => $request->getMessage(),
            'statusEnum' => new SupportRequestStatusEnum(SupportRequestStatusEnum::NEW),
        ]));

        $notificationResolver = $this->backendUserNotificationResolverFactory->make(
            new BackendUserNotificationTypeEnum(BackendUserNotificationTypeEnum::SUPPORT_REQUEST),
        );

        $notificationResolver->resolve($supportRequest);

        return new JsonResource($supportRequest);
    }
}
