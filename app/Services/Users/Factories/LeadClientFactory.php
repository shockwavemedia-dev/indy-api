<?php

declare(strict_types=1);

namespace App\Services\Users\Factories;

use App\Enum\UserTypeEnum;
use App\Models\Users\LeadClient;
use App\Repositories\Interfaces\LeadClientRepositoryInterface;
use App\Services\Users\Interfaces\CreateUserTypeResourceInterface;
use App\Services\Users\Interfaces\UserTypeFactoryInterface;
use App\Services\Users\Resources\CreateLeadClientResource;

final class LeadClientFactory implements UserTypeFactoryInterface
{
    private LeadClientRepositoryInterface $repository;

    public function __construct(LeadClientRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function create(CreateLeadClientResource|CreateUserTypeResourceInterface $resource): LeadClient
    {
        /** @var \App\Models\Users\LeadClient $leadClient */
        $leadClient = $this->repository->create([
            'company_name' => $resource->getCompanyName(),
            'full_name' => $resource->getFullName(),
        ]);

        return $leadClient;
    }

    public function supports(UserTypeEnum $userType): bool
    {
        return $userType->getValue() === UserTypeEnum::LEAD_CLIENT;
    }
}
