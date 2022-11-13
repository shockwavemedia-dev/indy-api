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
use App\Repositories\Interfaces\FileRepositoryInterface;
use App\Services\EmailLogs\Interfaces\EmailLogFactoryInterface;
use App\Services\EmailLogs\resources\CreateEmailLogResource;
use App\Services\FileManager\Interfaces\BucketFactoryInterface;
use App\Services\FileManager\Interfaces\FileUploaderInterface;
use App\Services\FileManager\Resources\UploadFileResource;
use App\Services\Files\Interfaces\FileFactoryInterface;
use App\Services\Files\Resources\CreateFileResource;
use App\Services\PrinterJobs\Interfaces\PrinterJobAttachmentFactoryInterface;
use App\Services\PrinterJobs\Interfaces\PrinterJobFactoryInterface;
use App\Services\PrinterJobs\Resources\CreatePrinterJobResource;
use App\Services\PrinterJobs\Resources\CreateAttachmentResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

final class CreatePrinterJobsController extends AbstractAPIController
{
    private ClientRepositoryInterface $clientRepository;

    private EmailLogFactoryInterface $emailLogFactory;

    private PrinterJobFactoryInterface $printerJobFactory;

    private PrinterJobAttachmentFactoryInterface $printerJobAttachmentFactory;

    private BucketFactoryInterface $bucketFactory;

    private FileFactoryInterface $fileFactory;

    private FileUploaderInterface $fileUploader;

    private FileRepositoryInterface $fileRepository;

    public function __construct(
        ClientRepositoryInterface $clientRepository,
        EmailLogFactoryInterface $emailLogFactory,
        PrinterJobFactoryInterface $printerJobFactory,
        PrinterJobAttachmentFactoryInterface $printerJobAttachmentFactory,
        BucketFactoryInterface $bucketFactory,
        FileFactoryInterface $fileFactory,
        FileUploaderInterface $fileUploader,
        FileRepositoryInterface $fileRepository,

    ) {
        $this->clientRepository = $clientRepository;
        $this->emailLogFactory = $emailLogFactory;
        $this->printerJobFactory = $printerJobFactory;
        $this->printerJobAttachmentFactory = $printerJobAttachmentFactory;
        $this->bucketFactory = $bucketFactory;
        $this->fileFactory = $fileFactory;
        $this->fileUploader = $fileUploader;
        $this->fileRepository = $fileRepository;
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
            'attachments',
            'file_ids'
        ]);

        $data = [];

//        foreach ($payload as $index => $request) {
//            $data[Str::camel($index)] = $request;
//        }

        $data = [
            ...$payload,
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

        if (array_key_exists('attachments',$payload) && count($payload['attachments']) > 0) {
            $bucket = $this->bucketFactory->make($client->getClientCode());

            foreach ($payload['attachments'] as $attachment) {
                $fileModel = $this->fileFactory->make(new CreateFileResource([
                    'uploadedFile' => $attachment,
                    'disk' => $bucket->disk(),
                    'filePath' => sprintf('printer-job/%s', $printerJob->getId()),
                    'folder' => null,
                    'uploadedBy' => $this->getUser(),
                    'bucket' => $bucket->name(),
                ]));

                $this->printerJobAttachmentFactory->make(new CreateAttachmentResource([
                    'printerJob' => $printerJob,
                    'file' => $fileModel,
                ]));

                $this->fileUploader->upload(new UploadFileResource([
                    'fileModel' => $fileModel,
                    'fileObject' => $attachment,
                ]));
            }
        }

        if (count($payload['file_ids'] ?? []) > 0) {
            $files = $this->fileRepository->findByIds($payload['file_ids']);

            foreach ($files as $file) {
                $this->printerJobAttachmentFactory->make(new CreateAttachmentResource([
                    'printerJob' => $printerJob,
                    'file' => $file,
                ]));
            }
        }

        return new PrinterJobResource($printerJob);
    }
}
