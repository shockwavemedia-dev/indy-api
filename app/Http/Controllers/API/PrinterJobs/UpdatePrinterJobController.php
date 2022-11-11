<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\PrinterJobs;

use App\Enum\UserTypeEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\PrinterJobs\CreatePrinterJobRequest;
use App\Http\Resources\API\PrinterJobs\PrinterJobResource;
use App\Jobs\PrinterJobs\GenericPrintManagerSlackNotificationJob;
use App\Models\PrinterJob;
use App\Repositories\Interfaces\FileRepositoryInterface;
use App\Repositories\Interfaces\PrinterJobRepositoryInterface;
use App\Services\FileManager\Interfaces\BucketFactoryInterface;
use App\Services\FileManager\Interfaces\FileUploaderInterface;
use App\Services\FileManager\Resources\UploadFileResource;
use App\Services\Files\Interfaces\FileFactoryInterface;
use App\Services\Files\Resources\CreateFileResource;
use App\Services\PrinterJobs\Interfaces\PrinterJobAttachmentFactoryInterface;
use App\Services\PrinterJobs\Interfaces\UpdatePrinterJobResolverInterface;
use App\Services\PrinterJobs\Resources\CreateAttachmentResource;
use Illuminate\Http\Resources\Json\JsonResource;

final class UpdatePrinterJobController extends AbstractAPIController
{
    private PrinterJobRepositoryInterface $printerJobRepository;

    private UpdatePrinterJobResolverInterface $updatePrinterJobResolver;

    private PrinterJobAttachmentFactoryInterface $printerJobAttachmentFactory;

    private BucketFactoryInterface $bucketFactory;

    private FileFactoryInterface $fileFactory;

    private FileUploaderInterface $fileUploader;

    private FileRepositoryInterface $fileRepository;

    public function __construct(
        PrinterJobRepositoryInterface $printerJobRepository,
        UpdatePrinterJobResolverInterface $updatePrinterJobResolver,
        PrinterJobAttachmentFactoryInterface $printerJobAttachmentFactory,
        BucketFactoryInterface $bucketFactory,
        FileFactoryInterface $fileFactory,
        FileUploaderInterface $fileUploader,
        FileRepositoryInterface $fileRepository,
    ) {
        $this->printerJobRepository = $printerJobRepository;
        $this->updatePrinterJobResolver = $updatePrinterJobResolver;
        $this->printerJobAttachmentFactory = $printerJobAttachmentFactory;
        $this->bucketFactory = $bucketFactory;
        $this->fileFactory = $fileFactory;
        $this->fileUploader = $fileUploader;
        $this->fileRepository = $fileRepository;
    }

    public function __invoke(int $id, CreatePrinterJobRequest $request): JsonResource
    {
        /** @var PrinterJob $printerJob */
        $printerJob = $this->printerJobRepository->find($id);

        if ($printerJob === null) {
            return $this->respondNotFound(['message' => 'Printer job not found.']);
        }

        if (
            $this->getUser()->getUserType()->getType()->getValue() !== UserTypeEnum::ADMIN &&
            $printerJob->client->getId() !== $this->getUser()->getUserType()->getClient()->getId()
        ) {
            return $this->respondForbidden();
        }


        $changes = $request->only([
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



        $changes['reseller_samples'] = filter_var($changes['reseller_samples'] ?? null, FILTER_VALIDATE_BOOLEAN);

        $changes['blind_shipping'] = filter_var($changes['blind_shipping'] ?? null, FILTER_VALIDATE_BOOLEAN);

        $changes = [
            ...$changes,
            ...[
                'updated_by' => $this->getUser()->getId(),
            ],
        ];

        $printerJob = $this->updatePrinterJobResolver->resolve($printerJob, $changes);

        $message = \sprintf('Hi %s, %s has updated the printer job request.',
            $this->getUser()->getFirstName(),
            $printerJob->getPrinter()->getUser()->getFirstName(),
        );

        GenericPrintManagerSlackNotificationJob::dispatch($printerJob->getId(), $message);

        if (array_key_exists('attachments',$changes) && count($changes['attachments']) > 0) {
            $bucket = $this->bucketFactory->make($printerJob->getClient()->getClientCode());

            foreach ($changes['attachments'] as $attachment) {
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

        if (count($changes['file_ids'] ?? []) > 0) {
            $files = $this->fileRepository->findByIds($changes['file_ids']);

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
