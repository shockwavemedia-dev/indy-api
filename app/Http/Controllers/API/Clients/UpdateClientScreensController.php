<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Clients;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Clients\UpdateClientScreensRequest;
use App\Http\Resources\API\Clients\ClientResource;
use App\Models\Client;
use App\Models\ClientScreen;
use App\Models\Screen;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Repositories\Interfaces\ScreenRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class UpdateClientScreensController extends AbstractAPIController
{
    private ClientRepositoryInterface $clientRepository;

    private ScreenRepositoryInterface $screenRepository;

    public function __construct(
        ClientRepositoryInterface $clientRepository,
        ScreenRepositoryInterface $screenRepository,
    ) {
        $this->clientRepository = $clientRepository;
        $this->screenRepository = $screenRepository;
    }
    public function __invoke(UpdateClientScreensRequest $request, int $id): JsonResource
    {
        /** @var Client $client */
        $client = $this->clientRepository->find($id);

        ClientScreen::where('client_id', $client->getId())->delete();

        foreach ($request->getScreenIds() as $screenId) {
            ClientScreen::create([
               'client_id' => $client->getId(),
               'screen_id' =>  $screenId,
            ]);
        }

        $client->refresh();

        return new ClientResource($client);
    }
}
