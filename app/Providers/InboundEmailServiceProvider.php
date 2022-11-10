<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\InboundEmails\Interfaces\EmailAttachmentProcessorInterface;
use App\Services\InboundEmails\Interfaces\EmailAttachmentUploadProcessorInterface;
use App\Services\InboundEmails\Interfaces\EmailTicketProcessorInterface;
use App\Services\InboundEmails\Interfaces\MailMimeParserResolverInterface;
use App\Services\InboundEmails\Processors\EmailAttachmentProcessor;
use App\Services\InboundEmails\Processors\EmailAttachmentUploadProcessor;
use App\Services\InboundEmails\Processors\EmailTicketProcessor;
use App\Services\InboundEmails\Resolvers\MailMimeParserResolver;
use Illuminate\Support\ServiceProvider;

final class InboundEmailServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $services = [
            EmailTicketProcessorInterface::class => EmailTicketProcessor::class,
            MailMimeParserResolverInterface::class => MailMimeParserResolver::class,
            EmailAttachmentProcessorInterface::class => EmailAttachmentProcessor::class,
            EmailAttachmentUploadProcessorInterface::class => EmailAttachmentUploadProcessor::class,
        ];

        foreach ($services as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
