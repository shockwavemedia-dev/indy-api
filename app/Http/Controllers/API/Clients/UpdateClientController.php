<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Clients;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Clients\UpdateClientRequest;
use App\Http\Resources\API\Clients\ClientResource;
use App\Jobs\File\UploadFileJob;
use App\Models\Client;
use App\Models\User;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Services\Clients\Resources\UpdateClientResource;
use App\Services\FileManager\Interfaces\BucketFactoryInterface;
use App\Services\Files\Interfaces\FileFactoryInterface;
use App\Services\Files\Resources\CreateFileResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class UpdateClientController extends AbstractAPIController
{
    public const INTERNAL_BUCKET = 'CRM-ADMIN';

    private ClientRepositoryInterface $clientRepository;

    private BucketFactoryInterface $bucketFactory;

    private FileFactoryInterface $fileFactory;

    public function __construct(
        ClientRepositoryInterface $clientRepository,
        BucketFactoryInterface $bucketFactory,
        FileFactoryInterface $fileFactory
    ) {
        $this->clientRepository = $clientRepository;
        $this->bucketFactory = $bucketFactory;
        $this->fileFactory = $fileFactory;
    }

    public function __invoke(UpdateClientRequest $request, int $id): JsonResource
    {
        /** @var Client $client */
        $client = $this->clientRepository->find($id);

        if ($client === null) {
            return $this->respondNotFound([
                'message' => 'Client not found.',
            ]);
        }

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

            //@TODO validation if there is update needed if not return early.
            $client = $this->clientRepository->update($client, new UpdateClientResource([
                'name' => $request->getName() ?? $client->getName(),
                'clientCode' => $request->getClientCode() ?? $client->getClientCode(),
                'address' => $request->getAddress() ?? $client->getAddress(),
                'phone' => $request->getPhone() ?? $client->getPhone(),
                'timezone' => $request->getTimezone() ?? $client->getTimezone(),
                'clientSince' => $request->getClientSince() ?? $client->getClientSince(),
                'mainClientId' => $request->getMainClientId() ?? $client->getMainClientId(),
                'overview' => $request->getOverview() ?? $client->getOverview(),
                'rating' => $request->getRating() ?? $client->getRating(),
                'status' => $request->getStatus() ?? $client->getStatus(),
                'logoFileId' => $file?->getId() ?? $client->getLogoFileId(),
                'designatedDesignerId' => $request->getDesignatedDesignerId() ?? $client->getDesignatedDesignerId(),
                'designatedAnimatorId' => $request->getDesignatedAnimatorId() ?? $client->getDesignatedAnimatorId(),
                'designatedWebEditorId' => $request->getDesignatedWebEditorId() ?? $client->getDesignatedWebEditorId(),
                'designatedSocialMediaManagerId' => $request->getDesignatedSocialMediaManagerId() ?? $client->getDesignatedSocialMediaManagerId(),
                'designatedPrinterManagerId' => $request->getDesignatedPrinterManagerId() ?? $client->getDesignatedPrinterManagerId(),
                'styleGuide' => $request->getStyleGuide() ?? $client->getStyleGuide(),
                'note' => $request->getNote() ?? $client->getNote(),
                'printerId' => $request->getPrinterId() ?? $client->getPrinterId() ?? null,
            ]));

            $client->refresh();

            return new ClientResource($client);
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
