<?php

namespace App\Services\TicketAssignee\Interfaces;

use App\Enum\ServicesEnum;

interface DesignatorResolverFactoryInterface
{
    public function make(ServicesEnum $serviceType): DesignatorResolverInterface;
}
