<?php

declare(strict_types=1);

namespace App\Services\Sorting;

use App\Models\File;
use App\Services\Sorting\Interfaces\SortByYearAndMonthResolverInterface;
use Illuminate\Database\Eloquent\Collection;

final class SortByYearAndMonthResolver implements SortByYearAndMonthResolverInterface
{
    public function resolve(Collection $data): array
    {
        $result = [];

        /** @var File $record */
        foreach ($data as $record) {
            if ($record->getFilePath() !== '') {
                continue;
            }

            $year = \sprintf(
                '%s',
                $record->getCreatedAt()->format('Y')
            );

            $month = $record->getCreatedAt()->format('F');

            $record->client_ticket_file = $record->getClientTicketFile();

            $record->folder_name = $record->getFolder()->getName();

            $result[$year][$month][] = $record;
        }

        return $result;
    }
}
