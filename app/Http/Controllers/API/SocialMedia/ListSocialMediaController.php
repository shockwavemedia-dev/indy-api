<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\SocialMedia;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\PaginationRequest;
use App\Http\Resources\API\SocialMedia\SocialMediaListResource;
use App\Models\Client;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Repositories\Interfaces\SocialMediaRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class ListSocialMediaController extends AbstractAPIController
{
    private ClientRepositoryInterface $clientRepository;

    private SocialMediaRepositoryInterface $socialMediaRepository;

    public function __construct(
        ClientRepositoryInterface $clientRepository,
        SocialMediaRepositoryInterface $socialMediaRepository,
    ) {
        $this->clientRepository = $clientRepository;
        $this->socialMediaRepository = $socialMediaRepository;
    }

    public function __invoke(PaginationRequest $request, int $id): JsonResource
    {
        /** @var Client $client */
        $client = $this->clientRepository->find($id);

        if ($client === null) {
            return $this->respondNotFound([
                'message' => 'Client not found.'
            ]);
        }

        return new SocialMediaListResource(
            $this->socialMediaRepository->findByClient(
                $client,
                $request->getSize(),
                $request->getPageNumber(),
            )
        );
    }
}
