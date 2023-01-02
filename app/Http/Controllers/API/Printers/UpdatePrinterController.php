<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Printers;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Printers\UpdatePrinterRequest;
use App\Http\Resources\API\Printers\PrinterResource;
use App\Jobs\File\UploadFileJob;
use App\Models\Printer;
use App\Repositories\Interfaces\PrinterRepositoryInterface;
use App\Services\FileManager\Interfaces\BucketFactoryInterface;
use App\Services\Files\Interfaces\FileFactoryInterface;
use App\Services\Files\Resources\CreateFileResource;
use Illuminate\Http\Resources\Json\JsonResource;

final class UpdatePrinterController extends AbstractAPIController
{
    private BucketFactoryInterface $bucketFactory;

    private FileFactoryInterface $fileFactory;

    private PrinterRepositoryInterface $printerRepository;

    public function __construct(
        BucketFactoryInterface $bucketFactory,
        FileFactoryInterface $fileFactory,
        PrinterRepositoryInterface $printerRepository,
    ) {
        $this->bucketFactory = $bucketFactory;
        $this->fileFactory = $fileFactory;
        $this->printerRepository = $printerRepository;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     * @throws \App\Services\FileManager\Exceptions\BucketNameExistsException
     * @throws \Exception
     */
    public function __invoke(UpdatePrinterRequest $request, int $id): JsonResource
    {
        /** @var Printer $printer */
        $printer = $this->printerRepository->find($id);

        if ($printer === null) {
            return $this->respondNotFound(['message' => 'Printer not found.']);
        }

        $file = null;

        if ($request->getLogo() !== null) {
            $bucket = $this->bucketFactory->make(self::INTERNAL_BUCKET);

            $file = $this->fileFactory->make(new CreateFileResource([
                'uploadedFile' => $request->getLogo(),
                'disk' => $bucket->disk(),
                'filePath' => 'printers',
                'uploadedBy' => $this->getUser(),
                'bucket' => $bucket->name(),
            ]));

            UploadFileJob::dispatch(
                $file->getId(),
                \base64_encode($request->getLogo()->get()),
            );
        }

        $existingPrinter = [
            'company_name' => $printer->getAttribute('company_name'),
            'contact_name' => $printer->getAttribute('contact_name'),
            'phone' => $printer->getAttribute('phone'),
            'description' => $printer->getAttribute('description'),
        ];

        $updates = [
            'file_id' => $file?->getId(),
            'company_name' => $request->getCompanyName(),
            'contact_name' => $request->getContactName(),
            'phone' => $request->getPhone(),
            'description' => $request->getDescription(),
        ];

        $updates = \array_diff($updates, $existingPrinter);

        $printer->update($updates);
        $printer->save();
        $printer->refresh();

        return new PrinterResource($printer);
    }
}
