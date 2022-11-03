<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\PrinterJobs;

use App\Enum\UserTypeEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\PaginationRequest;
use App\Http\Resources\API\PrinterJobs\PrinterJobsResource;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Repositories\Interfaces\PrinterJobRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class ListPrinterJobController extends AbstractAPIController
{
    private ClientRepositoryInterface $clientRepository;

    private PrinterJobRepositoryInterface $printerJobRepository;

    public function __construct(
        ClientRepositoryInterface $clientRepository,
        PrinterJobRepositoryInterface $printerJobRepository
    ) {
        $this->clientRepository = $clientRepository;
        $this->printerJobRepository = $printerJobRepository;
    }

    public function __invoke(int $id, PaginationRequest $request): JsonResource
    {
        $client = $this->clientRepository->find($id);

        if (
            $this->getUser()->getUserType()->getType()->getValue() !== UserTypeEnum::ADMIN &&
            $client->getId() !== $this->getUser()->getUserType()->getClient()->getId()
        ) {
            return $this->respondForbidden();
        }

        $printerJobs = $this->printerJobRepository->findByClient(
            $client,
            $request->getSize(),
            $request->getPageNumber()
        );

        return new PrinterJobsResource($printerJobs);
    }
}
