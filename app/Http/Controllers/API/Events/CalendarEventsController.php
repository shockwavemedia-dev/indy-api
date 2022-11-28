<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Events;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Events\CalendarEventsRequest;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Services\EventsService\Interfaces\CalendarStaffResolverInterface;
use Illuminate\Http\JsonResponse;

final class CalendarEventsController extends AbstractAPIController
{
    private CalendarStaffResolverInterface $calendarStaffResolver;

    private ClientRepositoryInterface $clientRepository;

    public function __construct(
        CalendarStaffResolverInterface $calendarStaffResolver,
        ClientRepositoryInterface $clientRepository
    ) {
        $this->calendarStaffResolver = $calendarStaffResolver;
        $this->clientRepository = $clientRepository;
    }

    public function __invoke(CalendarEventsRequest $request, int $id)
    {
        $client = $this->clientRepository->find($id);

        if ($client->getId() !== $this->getUser()->getUserType()->getClient()->getId()) {
            return $this->respondForbidden();
        }

        return new JsonResponse(
            $this->calendarStaffResolver->resolve(
                $client,
                (int) $request->get('month'),
                (int) $request->get('year')
            )
        );
    }
}
