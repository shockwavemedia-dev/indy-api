<?php

declare(strict_types=1);

namespace Tests\Unit\Services\ClientServices\Validations\Rules;

use App\Enum\ServiceExtraEnum;
use App\Enum\ServicesEnum;
use App\Models\ClientService;
use App\Models\Service;
use App\Services\ClientServices\Validations\Rules\ValidExtrasRuleService;
use App\Services\Tickets\Exceptions\InvalidExtraException;
use Illuminate\Support\Arr;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\Services\Tickets\Resolver\ServiceExtraResolverStub;

final class ValidExtrasRuleServiceTest extends TestCase
{
    public function testValidateSuccess(): void
    {
        $service = new Service();
        $service->setAttribute('name', ServicesEnum::GRAPHIC_DESIGN);
        $service->setAttribute('extras', ServiceExtraEnum::EXTRAS[ServicesEnum::GRAPHIC_DESIGN]);

        $clientService = new ClientService();
        $clientService->setMarketingQuota(0);

        $serviceExtraResolver = new ServiceExtraResolverStub([
            'resolve' => Arr::get(ServiceExtraEnum::EXTRAS, $service->getName()),
        ]);

        $rule = new ValidExtrasRuleService($serviceExtraResolver);

        $result = $rule->validate($clientService, $service, ['DL']);

        $this->assertTrue($result);
    }

    public function testValidateThrowException(): void
    {
        $service = new Service();
        $service->setAttribute('name', ServicesEnum::GRAPHIC_DESIGN);

        $clientService = new ClientService();

        $serviceExtraResolver = new ServiceExtraResolverStub([
            'resolve' => Arr::get(ServiceExtraEnum::EXTRAS, $service->getName()),
        ]);

        $rule = new ValidExtrasRuleService($serviceExtraResolver);

        $this->expectException(InvalidExtraException::class);

        $rule->validate($clientService, $service, ['Invalid Extra']);
    }
}
