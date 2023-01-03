<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Models\Client;
use App\Repositories\Interfaces\ClientTicketFileRepositoryInterface;
use App\Repositories\Interfaces\FileRepositoryInterface;
use App\Services\Sorting\Interfaces\SortByYearAndMonthResolverInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class TestController extends AbstractAPIController
{
    private FileRepositoryInterface $fileRepository;

    private SortByYearAndMonthResolverInterface $sortByYearAndMonthResolveritory;

    private ClientTicketFileRepositoryInterface $clientTicketFileRepository;

    public function __construct(
        FileRepositoryInterface $fileRepository,
        ClientTicketFileRepositoryInterface $clientTicketFileRepository,
        SortByYearAndMonthResolverInterface $sortByYearAndMonthResolver
    ) {
        $this->clientTicketFileRepository = $clientTicketFileRepository;
        $this->fileRepository = $fileRepository;
        $this->sortByYearAndMonthResolveritory = $sortByYearAndMonthResolver;
    }

    public function __invoke(): JsonResource
    {
        /** @var Client $client */
        $client = Client::find(1);

        $result = $this->fileRepository->findAllByClient($client);

        dd($result);
    }
}
