<?php

declare(strict_types=1);

namespace App\Services\MailChimp\Resolvers;

use App\Services\MailChimp\Interfaces\CampaignListResolverInterface;
use App\Services\MailChimp\Interfaces\MailChimpClientFactoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

final class CampaignListResolver implements CampaignListResolverInterface
{
    private MailChimpClientFactoryInterface $mailChimpClientFactory;

    public function __construct(MailChimpClientFactoryInterface $mailChimpClientFactory)
    {
        $this->mailChimpClientFactory = $mailChimpClientFactory;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function resolve(): Collection
    {
        $client = $this->mailChimpClientFactory->make();

        $campaigns = $client->campaigns->list(
            null,
            null,
            3,
            0,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            'create_time',
            'DESC',
        )->campaigns;

        if (\count($campaigns) === 0) {
            return new Collection();
        }

        $collection = new Collection();

        foreach ($campaigns as $campaign) {
            $sendDate = new Carbon($campaign->send_time);

            $collection->add([
                'id' => $campaign->id,
                'subject_line' => $campaign->settings->subject_line,
                'title' => $campaign->settings->title,
                'total_recipients' => $campaign->emails_sent,
                'send_time' => $sendDate->format('d-m-Y H:i:s'),
                'opens' => $campaign->report_summary?->unique_opens ?? 0,
                'clicks' => $campaign->report_summary?->clicks ?? 0,
            ]);
        }

        return $collection;
    }
}
