<?php

declare(strict_types=1);

namespace App\Services\SMS\Resolvers;

use App\Services\SMS\Interfaces\SmsConfigResolverInterface;
use App\Services\SMS\Resources\SmsConfigResource;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Arr;

final class SmsConfigResolver implements SmsConfigResolverInterface
{
    /**
     * @var string
     */
    private const CONFIG = 'sms';

    private Repository $configRepository;

    public function __construct(Repository $configRepository)
    {
        $this->configRepository = $configRepository;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function resolve(): SmsConfigResource
    {
        $config = $this->configRepository->get(self::CONFIG);

        return new SmsConfigResource([
            'password' => Arr::get($config, 'password'),
            'url' => Arr::get($config, 'url'),
            'username' => Arr::get($config, 'username'),

        ]);
    }
}
