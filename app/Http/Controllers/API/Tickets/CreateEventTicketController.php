<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Tickets;

use App\Enum\TicketTypeEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Tickets\CreateTicketEventRequest;
use App\Http\Resources\API\Tickets\TicketSupportResource;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Files\Interfaces\FileFactoryInterface;
use App\Services\Tickets\Exceptions\InvalidDueDateException;
use App\Services\Tickets\Exceptions\TicketEventServiceRuleException;
use App\Services\Tickets\Interfaces\Factories\TicketTypeResolverFactoryInterface;
use App\Services\Tickets\Interfaces\TicketAttachmentUploaderInterface;
use App\Services\Tickets\Interfaces\Validations\DueDateValidatorInterface;
use App\Services\Tickets\Interfaces\Validations\TicketEventServicesValidatorInterface;
use App\Services\Tickets\Resources\CreateTicketResource;
use App\Services\Tickets\Resources\UploadTicketAttachmentResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class CreateEventTicketController extends AbstractAPIController
{
    /**
     * @var int
     */
    private const MINIMUM_DELIVERY_DAYS = 1;

    private ClientRepositoryInterface $clientRepository;

    private TicketTypeResolverFactoryInterface $factory;

    private TicketEventServicesValidatorInterface $ticketEventServicesValidator;

    private UserRepositoryInterface $userRepository;

    public function __construct(
        ClientRepositoryInterface $clientRepository,
        TicketTypeResolverFactoryInterface $factory,
        TicketEventServicesValidatorInterface $ticketEventServicesValidator,
        UserRepositoryInterface $userRepository
    ) {
        $this->clientRepository = $clientRepository;
        $this->factory = $factory;
        $this->ticketEventServicesValidator = $ticketEventServicesValidator;
        $this->userRepository = $userRepository;
    }

    public function __invoke(CreateTicketEventRequest $request): JsonResource
    {
        try {
            $client = $this->clientRepository->find($request->getClientId());

            $requestedBy = $this->userRepository->find($request->getRequestedBy());

            $this->ticketEventServicesValidator->validate($client, $request->getServices());

            $ticketCreator = $this->factory->make(new TicketTypeEnum(TicketTypeEnum::EVENT));

            $ticket = $ticketCreator->create(new CreateTicketResource([
                'priority' => $request->getPriority(),
                'client' => $client,
                'createdBy' => $this->getUser(),
                'description' => $request->getDescription(),
                'requestedBy' => $requestedBy,
                'services' => $request->getServices(),
                'subject' => $request->getSubject(),
                'attachments' => $request->getAttachments(),
                'type' => new TicketTypeEnum(TicketTypeEnum::EVENT),
                'marketingPlannerEndDate' => $request->getMarketingPlannerEndDate(),
                'marketingPlannerStartDate' => $request->getMarketingPlannerStartDate(),
            ]));

            return new TicketSupportResource($ticket, $request->getServices());
        } catch (InvalidDueDateException $dueDateException) {
            return $this->respondBadRequest([
                'message' => $dueDateException->getMessage()
            ]);
        } catch (TicketEventServiceRuleException $serviceRuleException) {
                return $this->respondBadRequest([
                    'message' => $serviceRuleException->getMessage()
                ]);
        // @codeCoverageIgnoreStart
        } catch (Throwable $exception) {
            return $this->respondError($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        // @codeCoverageIgnoreEnd
    }
}
