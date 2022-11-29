<?php

declare(strict_types=1);

namespace App\Services\Sorting;

use App\Models\Client;
use App\Models\File;
use App\Services\Sorting\Interfaces\SortByYearAndMonthResolverInterface;
use Illuminate\Database\Eloquent\Collection;

final class SortByYearAndMonthResolver implements SortByYearAndMonthResolverInterface
{
    public function resolve(Client $client, Collection $data): array
    {
        $result = [];

        $filepath = \sprintf('%s/%s',
            $client->getClientCode(),
            'tickets'
        );


        /** @var File $record */
        foreach ($data as $record) {

            if ($record->getFilePath() !== $filepath) {
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
