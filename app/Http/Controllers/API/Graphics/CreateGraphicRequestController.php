<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Graphics;

use App\Enum\ServicesEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Graphics\CreateGraphicRequest;
use App\Http\Resources\API\Tickets\TicketSupportResource;
use App\Repositories\Interfaces\ServiceRepositoryInterface;
use App\Services\Graphics\Interfaces\Factories\GraphicRequestFactoryInterface;
use App\Services\Graphics\Resources\CreateGraphicRequestResource;
use App\Services\Tickets\Exceptions\TicketEventServiceRuleException;
use App\Services\Tickets\Interfaces\Validations\TicketEventServicesValidatorInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

final class CreateGraphicRequestController extends AbstractAPIController
{
    private GraphicRequestFactoryInterface $graphicRequestFactory;

    private ServiceRepositoryInterface $serviceRepository;

    private TicketEventServicesValidatorInterface $servicesValidator;

    public function __construct(
        GraphicRequestFactoryInterface $graphicRequestFactory,
        ServiceRepositoryInterface $serviceRepository,
        TicketEventServicesValidatorInterface $servicesValidator
    ) {
        $this->graphicRequestFactory = $graphicRequestFactory;
        $this->serviceRepository = $serviceRepository;
        $this->servicesValidator = $servicesValidator;
    }

    /**
     * @throws \App\Services\Tickets\Exceptions\TicketEventServiceRuleException
     */
    public function __invoke(CreateGraphicRequest $request): JsonResource
    {
        $service = $this->serviceRepository->findByName(ServicesEnum::GRAPHIC_DESIGN);

        if ($service === null) {
            return $this->respondBadRequest([
                'message' => \sprintf(
                    '%s service does not exist.',
                    ServicesEnum::GRAPHIC_DESIGN
                ),
            ]);
        }

        $user = $this->getUser();

        /** @var \App\Models\Users\ClientUser $clientUser */
        $clientUser = $user->getUserType();

        try {
            $serviceWithExtras = [
                'service_id' => $service->getId(),
                'extras' => $request->getExtras(),
            ];

            $this->servicesValidator->validate(
                $clientUser->getClient(),
                [$serviceWithExtras],
            );

            $ticket = $this->graphicRequestFactory->make(new CreateGraphicRequestResource([
                'requestedBy' => $user,
                'attachments' => $request->getAttachments(),
                'description' => $request->getDescription(),
                'subject' => $request->getSubject(),
                'service' => $serviceWithExtras,
            ]));

            return new TicketSupportResource($ticket);
        } catch (TicketEventServiceRuleException $serviceRuleException) {
            return $this->respondBadRequest([
                'message' => $serviceRuleException->getMessage(),
            ]);
            // @codeCoverageIgnoreStart
        } catch (\Throwable $throwable) {
            return $this->respondError(
                $throwable->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
        // @codeCoverageIgnoreEnd
    }
}
