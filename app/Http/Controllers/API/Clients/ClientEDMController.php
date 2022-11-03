<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Clients;

use App\Http\Controllers\API\AbstractAPIController;
use App\Services\MailChimp\Interfaces\CampaignListResolverInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class ClientEDMController extends AbstractAPIController
{
    private CampaignListResolverInterface $campaignListResolver;

//    private ClientRepositoryInterface $clientRepository;

    public function __construct(
        CampaignListResolverInterface $campaignListResolver,
//        ClientRepositoryInterface $clientRepository,
    ) {
        $this->campaignListResolver = $campaignListResolver;
//        $this->clientRepository = $clientRepository;
    }

    public function __invoke(int $id): JsonResource
    {
        $campaigns = $this->campaignListResolver->resolve();

        return new JsonResource($campaigns);
    }
}
