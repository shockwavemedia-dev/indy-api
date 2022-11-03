<?php

declare(strict_types=1);

namespace App\Http\Resources\API\Clients;

use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\Resource;
use App\Models\Client;
use App\Models\ClientScreen;

final class ClientResource extends Resource
{
    public static $wrap = null;

    /**
     * @return mixed[]
     * @throws InvalidResourceTypeException
     */
    protected function getResponse(): array
    {
        if (($this->resource instanceof Client) === false) {
            throw new InvalidResourceTypeException(Client::class);
        }

        /** @var Client $client */
        $client = $this->resource;

        $result =   [
            'id' => $client->getId(),
            'name' => $client->getName(),
            'client_code' => $client->getClientCode(),
            'address' => $client->getAddress(),
            'phone' => $client->getPhone(),
            'timezone' => $client->getTimezone(),
            'client_since' => $client->getClientSince()->toDateString(),
            'main_client_id' => $client->getMainClientId(),
            'overview' => $client->getOverview(),
            'rating' => $client->getRating(),
            'status' => $client->getStatus()->getValue(),
            'owner_id' => $client->getOwnerId(),
            'note' => $client->getNote(),
            'style_guide' => $client->getStyleGuide(),
            'printer' => $client->getPrinter(),
        ];

        /** @var ClientScreen $clientScreen */
        foreach ($client->getClientScreens() as $clientScreen) {
          $screen = $clientScreen->getScreen();

          $screen['logo'] = $clientScreen->getScreen()->getLogoFile();

          $result['screens'][] = $screen;
        }

        if($client->getDesignatedDesignerId() !== null){
            $result['designated_designer_id'] = $client->getDesignatedDesignerId();
            $result['designated_designer'] = $client->getDesignatedDesigner()->getUser()->getFullName();
        }
        if($client->getLogoFileId() !== null){
            $result['logo_url'] = $client->getLogo()->getUrl();
            $result['logo_thumbnail_url'] = $client->getLogo()->getThumbnailUrl();
        }

        return $result;
    }
}
