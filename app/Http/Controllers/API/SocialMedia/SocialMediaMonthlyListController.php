<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\SocialMedia;

use App\Enum\UserTypeEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Events\CalendarEventsRequest;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Services\SocialMedia\Interfaces\SocialMediaCalendarMonthResolverInterface;
use Illuminate\Http\JsonResponse;

final class SocialMediaMonthlyListController extends AbstractAPIController
{
    private ClientRepositoryInterface $clientRepository;

    private SocialMediaCalendarMonthResolverInterface $socialMediaCalendarMonthResolver;

    public function __construct(
        ClientRepositoryInterface $clientRepository,
        SocialMediaCalendarMonthResolverInterface $socialMediaCalendarMonthResolver
    ) {
        $this->clientRepository = $clientRepository;
        $this->socialMediaCalendarMonthResolver = $socialMediaCalendarMonthResolver;
    }

    public function __invoke(CalendarEventsRequest $request, int $id)
    {
        $client = $this->clientRepository->find($id);

        if (
            $this->getUser()->getUserType()->getType()->getValue() !== UserTypeEnum::ADMIN &&
            $client->getId() !== $this->getUser()->getUserType()->getClient()->getId()
        ) {
            return $this->respondForbidden();
        }

        return new JsonResponse(
            $this->socialMediaCalendarMonthResolver->resolve(
                $client,
                (int) $request->get('month'),
                (int) $request->get('year')
            )
        );
    }
}
