<?php

namespace App\Services\MailChimp\Interfaces;

use App\Services\MailChimp\Resources\ListResource;

interface ListResolverInterface
{
    public function resolve(string $listId): ListResource;
}
