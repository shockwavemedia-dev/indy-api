<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\InboundEmail;

use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Http\Controllers\API\AbstractAPIController;
use App\Models\User;
use App\Models\Users\ClientUser;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\FileManager\Interfaces\BucketFactoryInterface;
use App\Services\Files\Interfaces\FileFactoryInterface;
use App\Services\InboundEmails\Interfaces\EmailTicketProcessorInterface;
use App\Services\InboundEmails\Interfaces\MailMimeParserResolverInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

final class InboundEmailReceiverController extends AbstractAPIController
{
    public function __construct(
        private MailMimeParserResolverInterface $mailMimeParserResolver,
        private EmailTicketProcessorInterface $emailTicketProcessor,
        private UserRepositoryInterface $userRepository,
    ) {}

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     * @throws \App\Services\FileManager\Exceptions\BucketNameExistsException
     * @throws \League\Flysystem\FilesystemException
     */
    public function __invoke(Request $request): JsonResource
    {
        $parseEmail = $this->mailMimeParserResolver->resolve($request->get('email'));

        $serviceEmail = Config::get('mail.service_email');

        if ($parseEmail->getHeader('To')->getEmail() !== $serviceEmail) {
            return $this->respondNoContent();
        }

        /** @var User $userRequester */
        $userRequester = $this->userRepository->findByEmail(
            $parseEmail->getHeader('From')->getEmail()
        );

        if ($userRequester === null || $userRequester?->getUserType() instanceof ClientUser === false) {
            return $this->respondNoContent();
        }

        $this->emailTicketProcessor->process($parseEmail, $userRequester);

        return $this->respondNoContent();
    }
}
