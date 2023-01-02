<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Printers;

use App\Enum\UserStatusEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Printers\CreatePrinterRequest;
use App\Http\Resources\API\Printers\PrinterResource;
use App\Jobs\File\UploadFileJob;
use App\Services\FileManager\Interfaces\BucketFactoryInterface;
use App\Services\Files\Interfaces\FileFactoryInterface;
use App\Services\Files\Resources\CreateFileResource;
use App\Services\Printers\Interfaces\PrinterFactoryInterface;
use App\Services\Printers\Resources\CreatePrinterResource;
use App\Services\Users\Resources\CreateUserResource;
use App\Services\Users\UserCreationService;

final class CreatePrinterController extends AbstractAPIController
{
    /**
     * @var string
     */
    public const INTERNAL_BUCKET = 'CRM-ADMIN';

    private BucketFactoryInterface $bucketFactory;

    private FileFactoryInterface $fileFactory;

    private PrinterFactoryInterface $printerFactory;

    private UserCreationService $userCreationService;

    public function __construct(
        BucketFactoryInterface $bucketFactory,
        FileFactoryInterface $fileFactory,
        PrinterFactoryInterface $printerFactory,
        UserCreationService $userCreationService,
    ) {
        $this->bucketFactory = $bucketFactory;
        $this->fileFactory = $fileFactory;
        $this->printerFactory = $printerFactory;
        $this->userCreationService = $userCreationService;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     * @throws \App\Services\FileManager\Exceptions\BucketNameExistsException
     * @throws \Exception
     */
    public function __invoke(CreatePrinterRequest $request)
    {
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

        $printer = $this->printerFactory->make(new CreatePrinterResource([
            'logo' => $file,
            'email' => $request->getEmail(),
            'password' => $request->getPassword(),
            'createdBy' => $this->getUser(),
            'companyName' => $request->getCompanyName(),
            'contactName' => $request->getContactName(),
            'phone' => $request->getPhone(),
            'description' => $request->getDescription(),
        ]));

        $this->userCreationService->create(new CreateUserResource([
            'userType' => $printer,
            'email' => $request->getEmail(),
            'password' => $request->getPassword(),
            'status' => new UserStatusEnum(UserStatusEnum::ACTIVE),
            'firstName' => $request->getContactName(),
            'lastName' => 'Printer Provider',
            'contactNumber' => $request->getPhone(),
        ]));

        return new PrinterResource($printer);
    }
}
