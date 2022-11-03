<?php

declare(strict_types=1);

namespace App\Services\SocialMedia\Resolvers;

use App\Models\Client;
use App\Repositories\Interfaces\SocialMediaRepositoryInterface;
use App\Services\SocialMedia\Interfaces\SocialMediaCalendarMonthResolverInterface;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

final class SocialMediaCalendarMonthResolver implements SocialMediaCalendarMonthResolverInterface
{
    private SocialMediaRepositoryInterface $socialMediaRepository;

    public function __construct(SocialMediaRepositoryInterface $socialMediaRepository)
    {
        $this->socialMediaRepository = $socialMediaRepository;
    }

    public function resolve(Client $client, int $month, int $year): array
    {
        $socialMedias = $this->socialMediaRepository->findByClientMonthAndYear(
            $client,
            $month,
            $year
        );

        $results = [];

        $currentMonthYear = (new Carbon())
            ->month($month)
            ->setYear($year);

        $period = CarbonPeriod::create(
            $currentMonthYear->firstOfMonth()->toDateString(),
            $currentMonthYear->lastOfMonth()->toDateString()
        );

        foreach ($period as $date) {
            $results[$date->toDateString()] = [];

            foreach ($socialMedias as $socialMedia) {
                if ($socialMedia->post_date->toDateString() !== $date->toDateString()) {
                    continue;
                }

                $results[$date->toDateString()][] = $socialMedia;
            }
        }

        return $results;
    }
}
