<?php

declare(strict_types=1);

namespace App\Services\SupportRequests;

use App\Models\SupportRequest;
use App\Repositories\Interfaces\SupportRequestRepositoryInterface;
use App\Services\SupportRequests\Interfaces\SupportRequestFactoryInterface;
use App\Services\SupportRequests\Resources\CreateSupportRequestResource;

final class SupportRequestFactory implements SupportRequestFactoryInterface
{
    private SupportRequestRepositoryInterface $supportRequestRepository;

    public function __construct(SupportRequestRepositoryInterface $supportRequestRepository)
    {
        $this->supportRequestRepository = $supportRequestRepository;
    }

    public function make(CreateSupportRequestResource $resource): SupportRequest
    {
        /** @var SupportRequest $supportRequest */
        $supportRequest = $this->supportRequestRepository->create([
            'client_id' => $resource->getClient()->getId(),
            'created_by' => $resource->getCreatedBy()->getId(),
            'department_id' => $resource->getDepartment()->getId(),
            'message' => $resource->getMessage(),
            'status' => $resource->getStatus()->getValue(),
        ]);

        return $supportRequest;
    }
}
