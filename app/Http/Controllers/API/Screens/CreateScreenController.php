<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Screens;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Screens\CreateScreenRequest;
use App\Http\Resources\API\Screens\ScreenResource;
use App\Jobs\File\UploadFileJob;
use App\Models\File;
use App\Services\FileManager\Interfaces\BucketFactoryInterface;
use App\Services\Files\Interfaces\FileFactoryInterface;
use App\Services\Files\Resources\CreateFileResource;
use App\Services\Screens\Interfaces\ScreenFactoryInterface;
use App\Services\Screens\Resources\CreateScreenResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

final class CreateScreenController extends AbstractAPIController
{
    private BucketFactoryInterface $bucketFactory;

    private FileFactoryInterface $fileFactory;

    private ScreenFactoryInterface $screenFactory;

    public function __construct(
        BucketFactoryInterface $bucketFactory,
        FileFactoryInterface $fileFactory,
        ScreenFactoryInterface $screenFactory
    ) {
        $this->bucketFactory = $bucketFactory;
        $this->fileFactory = $fileFactory;
        $this->screenFactory = $screenFactory;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     * @throws \App\Services\FileManager\Exceptions\BucketNameExistsException
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function __invoke(CreateScreenRequest $request): JsonResource
    {
        /** @var File $file */
        $file = null;

        if ($request->file('logo') !== null) {
            $bucket = $this->bucketFactory->make(self::INTERNAL_BUCKET);

            $file = $this->fileFactory->make(new CreateFileResource([
                'uploadedFile' => $request->file('logo'),
                'disk' => $bucket->disk(),
                'filePath' => 'screens',
                'uploadedBy' => $this->getUser(),
                'bucket' => $bucket->name(),
            ]));

            UploadFileJob::dispatch(
                $file->getId(),
                \base64_encode($request->file('logo')->get()),
            );
        }

        $resource = new CreateScreenResource([
            'name' => $request->get('name'),
            'slug' => Str::slug($request->get('name')),
            'createdBy' => $this->getUser(),
            'logoFileId' => $file?->getId(),
        ]);

        $screen = $this->screenFactory->make($resource);

        return new ScreenResource($screen);
    }
}
