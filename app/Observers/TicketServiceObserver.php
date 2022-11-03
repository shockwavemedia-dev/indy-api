<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enum\ServicesEnum;
use App\Enum\SocialMediaStatusesEnum;
use App\Models\Tickets\TicketService;
use App\Services\SocialMedia\Interfaces\SocialMediaFactoryInterface;
use App\Services\SocialMedia\Resources\CreateSocialMediaResource;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

final class TicketServiceObserver
{
    private SocialMediaFactoryInterface $socialMediaFactory;

    public function __construct(SocialMediaFactoryInterface $socialMediaFactory) {
        $this->socialMediaFactory = $socialMediaFactory;
    }

    /**
     * @throws UnknownProperties
     */
    public function created(TicketService $ticketService): void
    {
        $this->resolveSocialMediaPost($ticketService);
    }

    /**
     * @throws UnknownProperties
     */
    private function resolveSocialMediaPost(TicketService $ticketService): void
    {
        if ($ticketService->getService()->getName() !== ServicesEnum::SOCIAL_MEDIA) {
            return;
        }

        $this->socialMediaFactory->make(new CreateSocialMediaResource([
            'ticket' => $ticketService->getTicket(),
            'client' => $ticketService->getTicket()->getClient(),
            'status' => new SocialMediaStatusesEnum(SocialMediaStatusesEnum::CLIENT_CREATED_DRAFT),
            'createdBy' => $ticketService->getTicket()->getCreatedBy(),
            'post' => $ticketService->getTicket()->getSubject(),
            'channels' => $ticketService->getExtras(),
        ]));
    }
}
