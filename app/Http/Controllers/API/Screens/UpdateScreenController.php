<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Screens;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Screens\UpdateScreenRequest;
use App\Http\Resources\API\Screens\ScreenResource;
use App\Jobs\File\UploadFileJob;
use App\Repositories\Interfaces\ScreenRepositoryInterface;
use App\Services\FileManager\Interfaces\BucketFactoryInterface;
use App\Services\Files\Interfaces\FileFactoryInterface;
use App\Services\Files\Resources\CreateFileResource;
use Illuminate\Http\Resources\Json\JsonResource;

final class UpdateScreenController extends AbstractAPIController
{
    private BucketFactoryInterface $bucketFactory;

    private FileFactoryInterface $fileFactory;

    private ScreenRepositoryInterface $screenRepository;

    public function __construct(
        BucketFactoryInterface $bucketFactory,
        FileFactoryInterface $fileFactory,
        ScreenRepositoryInterface $screenRepository
    ) {
        $this->bucketFactory = $bucketFactory;
        $this->fileFactory = $fileFactory;
        $this->screenRepository = $screenRepository;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     * @throws \App\Services\FileManager\Exceptions\BucketNameExistsException
     */
    public function __invoke(UpdateScreenRequest $request, int $id): JsonResource
    {
        $screen = $this->screenRepository->find($id);

        if ($screen === null) {
            return $this->respondNotFound(['message' => 'Screen not found']);
        }

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

        $updates = [
            'name' => $request->get('name'),
        ];

        if ($file !== null) {
            $updates['logo_file_id'] = $file->getId();
        }

        $existing = [
            'name' => $screen->getAttribute('name'),
        ];

        $updates = \array_diff($updates, $existing);

        $screen->update($updates);
        $screen->save();
        $screen->refresh();

        return new ScreenResource($screen);
    }
}
