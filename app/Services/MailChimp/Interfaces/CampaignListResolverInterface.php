<?php

namespace App\Services\MailChimp\Interfaces;

use App\Services\MailChimp\Resources\CampaignResource;
use Illuminate\Support\Collection;

interface CampaignListResolverInterface
{
    /**
     * @return Collection<CampaignResource>
     */
    public function resolve(): Collection;
}
