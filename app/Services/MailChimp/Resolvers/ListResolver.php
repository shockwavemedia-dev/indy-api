<?php

declare(strict_types=1);

namespace App\Services\MailChimp\Resolvers;

use App\Services\MailChimp\Interfaces\ListResolverInterface;
use App\Services\MailChimp\Interfaces\MailChimpClientFactoryInterface;
use App\Services\MailChimp\Resources\ListResource;

final class ListResolver implements ListResolverInterface
{
    private MailChimpClientFactoryInterface $mailChimpClientFactory;

    public function __construct(MailChimpClientFactoryInterface $mailChimpClientFactory) {
        $this->mailChimpClientFactory = $mailChimpClientFactory;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function resolve(string $listId): ListResource
    {
        $client = $this->mailChimpClientFactory->make();

        $list = $client->lists->getList($listId);

        return new ListResource([
            'id' => $list->id,
            'name' => $list->name,
            'memberCount' => $list->stats->member_count,
        ]);
    }
}
