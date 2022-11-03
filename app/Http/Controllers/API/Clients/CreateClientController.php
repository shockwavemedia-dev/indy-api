<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Clients;

use App\Enum\ClientStatusEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Clients\CreateClientRequest;
use App\Http\Resources\API\Clients\ClientResource;
use App\Jobs\File\UploadFileJob;
use App\Models\User;
use App\Services\Clients\Interfaces\ClientCreationServiceInterface;
use App\Services\Clients\Resources\CreateClientResource;
use App\Services\ClientServices\Interfaces\ClientServiceFactoryInterface;
use App\Services\FileManager\Interfaces\BucketFactoryInterface;
use App\Services\Files\Interfaces\FileFactoryInterface;
use App\Services\Files\Resources\CreateFileResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class CreateClientController extends AbstractAPIController
{
    public const INTERNAL_BUCKET = 'CRM-ADMIN';

    private ClientCreationServiceInterface $clientCreationService;

    private ClientServiceFactoryInterface $clientServiceFactory;

    private BucketFactoryInterface $bucketFactory;

    private FileFactoryInterface $fileFactory;

    public function __construct(
        ClientCreationServiceInterface $clientCreationService,
        ClientServiceFactoryInterface $clientServiceFactory,
        BucketFactoryInterface $bucketFactory,
        FileFactoryInterface $fileFactory,
    ) {
        $this->clientCreationService = $clientCreationService;
        $this->clientServiceFactory = $clientServiceFactory;
        $this->bucketFactory = $bucketFactory;
        $this->fileFactory = $fileFactory;
    }

    public function __invoke(CreateClientRequest $request): JsonResource
    {
        try {
            /** @var User $user */
            $user = $this->getUser();

            $file = null;

            if ($request->getLogo() !== null) {
                $bucket = $this->bucketFactory->make(self::INTERNAL_BUCKET);

                $file = $this->fileFactory->make(new CreateFileResource([
                    'uploadedFile' => $request->getLogo(),
                    'disk' => $bucket->disk(),
                    'filePath' => 'client_logo',
                    'uploadedBy' => $user,
                    'bucket' => $bucket->name(),
                ]));

                UploadFileJob::dispatch(
                    $file->getId(),
                    \base64_encode($request->getLogo()->get()),
                );
            }

            $client = $this->clientCreationService->create(new CreateClientResource([
                'name' => $request->getName(),
                'clientCode' => $request->getClientCode(),
                'address' => $request->getAddress(),
                'phone' => $request->getPhone(),
                'timezone' => $request->getTimezone(),
                'clientSince' => $request->getClientSince(),
                'mainClientId' => $request->getMainClientId(),
                'overview' => $request->getOverview(),
                'rating' => $request->getRating(),
                'logoFileId' => $file?->getId() ?? null,
                'designatedDesignerId' => $request->getDesignatedDesignerId(),
                'status' => new ClientStatusEnum(ClientStatusEnum::ACTIVE),
                'styleGuide' => $request->getStyleGuide(),
                'note' => $request->getNote(),
            ]));

            $this->clientServiceFactory->make($client,$user);

            // @TODO implement dispatching of event for sending of email
            return new ClientResource($client);
        // @codeCoverageIgnoreStart
        } catch (Throwable $exception) {
            return $this->respondError($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        // @codeCoverageIgnoreEnd
    }
}
