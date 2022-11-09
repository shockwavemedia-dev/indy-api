<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\PrinterJobs;

use App\Enum\EmailStatusEnum;
use App\Enum\PrinterJobStatusesEnum;
use App\Enum\UserTypeEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\PrinterJobs\CreatePrinterJobRequest;
use App\Http\Resources\API\PrinterJobs\PrinterJobResource;
use App\Jobs\PrinterJobs\GenericPrintManagerSlackNotificationJob;
use App\Models\Client;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Services\EmailLogs\Interfaces\EmailLogFactoryInterface;
use App\Services\EmailLogs\resources\CreateEmailLogResource;
use App\Services\PrinterJobs\Interfaces\PrinterJobFactoryInterface;
use App\Services\PrinterJobs\Resources\CreatePrinterJobResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

final class CreatePrinterJobsController extends AbstractAPIController
{
    private ClientRepositoryInterface $clientRepository;

    private EmailLogFactoryInterface $emailLogFactory;

    private PrinterJobFactoryInterface $printerJobFactory;

    public function __construct(
        ClientRepositoryInterface $clientRepository,
        EmailLogFactoryInterface $emailLogFactory,
        PrinterJobFactoryInterface $printerJobFactory
    ) {
        $this->clientRepository = $clientRepository;
        $this->emailLogFactory = $emailLogFactory;
        $this->printerJobFactory = $printerJobFactory;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function __invoke(CreatePrinterJobRequest $request, int $id): JsonResource
    {
        /** @var Client $client */
        $client = $this->clientRepository->find($id);

        if ($client === null) {
            return $this->respondNotFound([
                'message' => 'Client not found.'
            ]);
        }

        if (
            $this->getUser()->getUserType()->getType()->getValue() !== UserTypeEnum::ADMIN &&
            $client->getId() !== $this->getUser()->getUserType()->getClient()->getId()
        ) {
            return $this->respondForbidden();
        }

        if ($client->getPrinter() === null) {
            return $this->respondForbidden(['message' => 'Client does not have the access for this feature. Please contact System Administrator']);
        }

        $payload = $request->only([
            'customer_name',
            'product',
            'option',
            'kinds',
            'quantity',
            'run_ons',
            'format',
            'final_trim_size',
            'reference',
            'notes',
            'additional_options',
            'delivery',
            'price',
            'blind_shipping',
            'reseller_samples',
            'stocks',
            'coding',
            'address',
            'purchase_order_number',
            'attachments'
        ]);

        $data = [];

        foreach ($payload as $index => $request) {
            $data[Str::camel($index)] = $request;
        }

        $data = [
            ...$data,
            ...[
                'printerId' => $client->getPrinter()->getId(),
                'createdBy' => $this->getUser(),
                'client' => $client,
                'status' => new PrinterJobStatusesEnum(PrinterJobStatusesEnum::FOR_QUOTATION),
            ],
        ];

        $printerJob = $this->printerJobFactory->make(new CreatePrinterJobResource($data));

        $message = \sprintf(
            'Hi %s, %s has created a printer job request #%s.',
            $this->getUser()->getFirstName(),
            $client->getPrinter()->getAttribute('contact_name'),
            $printerJob->getId(),
        );

        $emailLog = $this->emailLogFactory->make(new CreateEmailLogResource([
            'message' => $message,
            'to' => $this->getUser()->getEmail(),
            'status' => new EmailStatusEnum(EmailStatusEnum::PENDING),
            'emailType' => $printerJob,
        ]));

        GenericPrintManagerSlackNotificationJob::dispatch($printerJob->getId(), $message);

        $client->getPrinter()->getUser()->sendEmailToPrinter($printerJob, $emailLog, $this->getUser());

        return new PrinterJobResource($printerJob);
    }
}
