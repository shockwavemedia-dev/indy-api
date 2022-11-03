<?php

declare(strict_types=1);

namespace App\Services\MarketingPlanners;

use App\Jobs\File\UploadFileJob;
use App\Jobs\MarketingPlanners\MarketingPlannerAttachmentCreationJob;
use App\Models\MarketingPlanner;
use App\Services\FileManager\Interfaces\BucketFactoryInterface;
use App\Services\Files\Interfaces\FileFactoryInterface;
use App\Services\Files\Resources\CreateFileResource;
use App\Services\MarketingPlanners\Interfaces\MarketingPlannerAttachmentProcessorInterface;
use Illuminate\Http\UploadedFile;

final class MarketingPlannerAttachmentProcessor implements MarketingPlannerAttachmentProcessorInterface
{
    private BucketFactoryInterface $bucketFactory;

    private FileFactoryInterface $fileFactory;

    public function __construct(
        BucketFactoryInterface $bucketFactory,
        FileFactoryInterface $fileFactory
    ) {
        $this->bucketFactory = $bucketFactory;
        $this->fileFactory = $fileFactory;
    }

    /**
     * @throws \App\Services\FileManager\Exceptions\BucketNameExistsException
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function process(MarketingPlanner $marketingPlanner, UploadedFile $file): void
    {
        $bucket = $this->bucketFactory->make($marketingPlanner->getClient()->getClientCode());

        $fileModel = $this->fileFactory->make(new CreateFileResource([
            'uploadedFile' => $file,
            'disk' => $bucket->disk(), // Default to google cloud server driver
            'filePath' => 'marketing-planner-attachment',
            'uploadedBy' => $marketingPlanner->getCreatedBy(),
            'bucket' => $bucket->name(),
        ]));

        MarketingPlannerAttachmentCreationJob::dispatch($fileModel->getId(), $marketingPlanner->getId());

        UploadFileJob::dispatch(
            $fileModel->getId(),
            \base64_encode($file->get())
        );
    }
}
