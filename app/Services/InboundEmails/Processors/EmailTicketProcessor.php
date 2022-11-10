<?php

namespace App\Services\InboundEmails\Processors;

use App\Enum\TicketPrioritiesEnum;
use App\Enum\TicketTypeEnum;
use App\Models\User;
use App\Services\InboundEmails\Interfaces\EmailAttachmentProcessorInterface;
use App\Services\InboundEmails\Interfaces\EmailTicketProcessorInterface;
use App\Services\Tickets\Interfaces\Factories\TicketTypeResolverFactoryInterface;
use App\Services\Tickets\Resources\CreateTicketResource;
use ZBateson\MailMimeParser\IMessage;

final class EmailTicketProcessor implements EmailTicketProcessorInterface
{
    public function __construct(
        private EmailAttachmentProcessorInterface $emailAttachmentProcessor,
        private TicketTypeResolverFactoryInterface $ticketTypeResolverFactory
    ) {}

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function process(IMessage $message, User $user): void
    {
        $emailDescription = $message->getHtmlContent();

        $subject = $message->getHeaderValue('Subject');

        $ticketCreator = $this->ticketTypeResolverFactory->make(
            new TicketTypeEnum(TicketTypeEnum::EMAIL)
        );

        $emailDescription = [
            "data" => $emailDescription,
        ];

        $ticket = $ticketCreator->create(new CreateTicketResource([
            'priority' => new TicketPrioritiesEnum(TicketPrioritiesEnum::STANDARD),
            'client' => $user->getUserType()->getClient(),
            'createdBy' => User::find(1),
            'description' => "{\"blocks\":[{\"key\":\"a7itc\",\"text\":\"\",\"type\":\"unstyled\",\"depth\":0,\"inlineStyleRanges\":[],\"entityRanges\":[],\"data\":{}}],\"entityMap\":{}}",
            'requestedBy' => $user,
            'services' => [],
            'subject' => $subject,
            'type' => new TicketTypeEnum(TicketTypeEnum::EMAIL),
            'emailHtml' => $emailDescription,
        ]));

        $this->emailAttachmentProcessor->process($ticket, $message->getAllAttachmentParts());
    }
}
