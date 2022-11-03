<?php

declare(strict_types=1);

namespace App\Services\EventsService\Resolvers;

use App\Models\Client;
use App\Models\Event;
use App\Models\Users\AdminUser;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Repositories\Interfaces\EventRepositoryInterface;
use App\Services\EventsService\Interfaces\CalendarStaffResolverInterface;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Collection;

final class CalendarStaffResolver implements CalendarStaffResolverInterface
{
    private DepartmentRepositoryInterface $departmentRepository;

    private EventRepositoryInterface $eventRepository;

    public function __construct(
        DepartmentRepositoryInterface $departmentRepository,
        EventRepositoryInterface $eventRepository
    ) {
        $this->departmentRepository = $departmentRepository;
        $this->eventRepository = $eventRepository;
    }

    public function resolve(
        Client $client,
        int $month,
        int $year
    ): array {
        $staffs = $this->departmentRepository
            ->findByNameLike('Photographer')
            ->getStaffs();

        $events = $this->eventRepository->findByClientMonthAndYear(
            $client,
            $month,
            $year,
        );

        $results = [];

        $currentMonthYear = (new Carbon())
            ->month($month)
            ->setYear($year);

        $period = CarbonPeriod::create(
            $currentMonthYear->firstOfMonth()->toDateString(),
            $currentMonthYear->lastOfMonth()->toDateString()
        );

        $staffs = $this->initializeStaffs($staffs);

        foreach ($period as $date) {
            $currentEvents = $events->where('shoot_date', $date->toDateString());

            if ($currentEvents->isEmpty() === true) {
                $results[$date->toDateString()] = $staffs;
                continue;
            }

            $currentStaffs = $staffs;

            /** @var Event $currentEvent */
            foreach ($currentEvents as $currentEvent) {
                if ($currentEvent->getPhotographer() === null) {
                    continue;
                }

                $currentStaffs = $this->resolveStaffs($currentStaffs, $currentEvent->getPhotographer());
            }

            $results[$date->toDateString()] = $currentStaffs;
        }

        return $results;
    }

    private function resolveStaffs(Collection $staffs, AdminUser $staffEvent): Collection
    {
        $results = new Collection();

        foreach ($staffs as $staff) {
            if ($staff->get('id') !== $staffEvent->getId()) {
                $results->add($staff);

                continue;
            }

            $results->add(collect([
                'status' => 'booked',
                'name' => $staff->get('name'),
                'id' => $staff->get('id'),
            ]));
        }

        return $results;
    }

    private function initializeStaffs(Collection $staffs): Collection
    {
        $results = new Collection();

        foreach ($staffs as $staff) {
            $results->add(collect([
                'status' => 'available',
                'name' => $staff->getUser()->getFullName(),
                'id' => $staff->getId(),
            ]));
        }

        return $results;
    }
}
