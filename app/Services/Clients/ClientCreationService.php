<?php

declare(strict_types=1);

namespace App\Services\Clients;

use App\Models\Client;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Services\Clients\Interfaces\ClientCreationServiceInterface;
use App\Services\Clients\Resources\CreateClientResource;

final class ClientCreationService implements ClientCreationServiceInterface
{
    private ClientRepositoryInterface $clientRepository;

    public function __construct(
        ClientRepositoryInterface $clientRepository,
    ) {
        $this->clientRepository = $clientRepository;
    }

    public function create(CreateClientResource $resource): Client
    {
        /** @var Client $client */
        $client = $this->clientRepository->create([
            'name' => $resource->getName(),
            'client_code' => $resource->getClientCode(),
            'logo_file_id' => $resource->getLogoFileId() ?? null,
            'address' => $resource->getAddress(),
            'phone' => $resource->getPhone(),
            'timezone' => $resource->getTimezone(),
            'client_since' => $resource->getClientSince(),
            'main_client_id' => $resource->getMainClientId() ?? null,
            'overview' => $resource->getOverview(),
            'rating' => $resource->getRating(),
            'status' => $resource->getStatus(),
            'designated_designer_id' => $resource->getDesignatedDesignerId() ?? null,
            'designated_animator_id' => $resource->getDesignatedAnimatorId() ?? null,
            'designated_web_editor_id' => $resource->getDesignatedWebEditorId() ?? null,
            'designated_social_media_manager_id' => $resource->getDesignatedSocialMediaManagerId() ?? null,
            'designated_printer_manager_id' => $resource->getDesignatedPrinterManagerId() ?? null,
            'style_guide' => $resource->getStyleGuide(),
            'note' => $resource->getNote(),
        ]);

        return $client;
    }
}
