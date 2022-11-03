<?php

declare(strict_types=1);

namespace App\Services\MailChimp\Factories;

use App\Services\MailChimp\Interfaces\MailChimpClientFactoryInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use MailchimpMarketing\ApiClient;
use Exception;

final class MailChimpClientFactory implements MailChimpClientFactoryInterface
{
    /**
     * @throws \Exception
     */
    public function make(): ApiClient
    {
        $config = Config::get('services.mailchimp', null);

        $key = Arr::get($config, 'key');

        $server = Arr::get($config, 'server');

        if ($key === null || $server === null) {
            throw new Exception('Invalid Configuration');
        }

        $mailchimp = new ApiClient();

        $mailchimp->setConfig([
            'apiKey' => $key,
            'server' => $server
        ]);

        $checkPing = $mailchimp->ping->get();

        if ($checkPing->health_status === "Everything's Chimpy!") {
            return $mailchimp;
        }

        throw new Exception('Invalid Configuration');
    }
}
