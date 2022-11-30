<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Interfaces\ServiceRepositoryInterface;
use App\Services\TicketActivities\Interfaces\TicketActivityFactoryInterface;
use App\Services\TicketActivities\TicketActivityFactory;
use App\Services\TicketNotes\Interfaces\TicketNoteFactoryInterface;
use App\Services\TicketNotes\TicketNoteFactory;
use App\Services\Tickets\AssignTicketService;
use App\Services\Tickets\Factories\EmailTicketFactory;
use App\Services\Tickets\Factories\GenericTicketFactory;
use App\Services\Tickets\Factories\TicketEventAttachmentFactory;
use App\Services\Tickets\Factories\TicketEventFactory;
use App\Services\Tickets\Factories\TicketNotificationResolverFactory;
use App\Services\Tickets\Factories\TicketServicesFactory;
use App\Services\Tickets\Factories\TicketTypeResolverFactory;
use App\Services\Tickets\Interfaces\AssignTicketServiceInterface;
use App\Services\Tickets\Interfaces\Factories\TicketEventAttachmentFactoryInterface;
use App\Services\Tickets\Interfaces\Factories\TicketNotificationResolverFactoryInterface;
use App\Services\Tickets\Interfaces\Factories\TicketServicesFactoryInterface;
use App\Services\Tickets\Interfaces\Factories\TicketTypeResolverFactoryInterface;
use App\Services\Tickets\Interfaces\Resolvers\ServiceExtraResolverInterface;
use App\Services\Tickets\Interfaces\Resolvers\TicketNotificationResolverInterface;
use App\Services\Tickets\Interfaces\Resolvers\TicketNotifyDepartmentsResolverInterface;
use App\Services\Tickets\Interfaces\Resolvers\TicketTypeResolverInterface;
use App\Services\Tickets\Interfaces\TicketAttachmentUploaderInterface;
use App\Services\Tickets\Interfaces\Validations\DueDateValidatorInterface;
use App\Services\Tickets\Interfaces\Validations\TicketEventServicesValidatorInterface;
use App\Services\Tickets\Interfaces\Validations\TicketEventServiceValidationRuleInterface;
use App\Services\Tickets\Resolvers\ServiceExtraResolver;
use App\Services\Tickets\Resolvers\TicketCreatedNotificationResolver;
use App\Services\Tickets\Resolvers\TicketNotifyDepartmentsResolver;
use App\Services\Tickets\TicketAttachmentUploader;
use App\Services\Tickets\Validations\DueDateValidator;
use App\Services\Tickets\Validations\Rules\ClientServiceEnableRuleService;
use App\Services\Tickets\Validations\Rules\ClientServiceUsageRuleService;
use App\Services\Tickets\Validations\Rules\ValidExtrasRuleService;
use App\Services\Tickets\Validations\TicketEventServicesValidator;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

final class TicketServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $services = [
            AssignTicketServiceInterface::class => AssignTicketService::class,
            DueDateValidatorInterface::class => DueDateValidator::class,
            ServiceExtraResolverInterface::class => ServiceExtraResolver::class,
            TicketActivityFactoryInterface::class => TicketActivityFactory::class,
            TicketAttachmentUploaderInterface::class => TicketAttachmentUploader::class,
            TicketEventAttachmentFactoryInterface::class => TicketEventAttachmentFactory::class,
            TicketNoteFactoryInterface::class => TicketNoteFactory::class,
            TicketNotifyDepartmentsResolverInterface::class => TicketNotifyDepartmentsResolver::class,
            TicketServicesFactoryInterface::class => TicketServicesFactory::class,
        ];

        foreach ($services as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }

        $this->app->tag(
            [
                GenericTicketFactory::class,
                TicketEventFactory::class,
                EmailTicketFactory::class,
            ],
            TicketTypeResolverInterface::class
        );

        $this->app->bind(TicketTypeResolverFactoryInterface::class,
            static function (Application $app) {
                return new TicketTypeResolverFactory($app->tagged(TicketTypeResolverInterface::class));
            }
        );

        $this->app->tag(
            [
                ClientServiceEnableRuleService::class,
                ClientServiceUsageRuleService::class,
                ValidExtrasRuleService::class,
            ],
            TicketEventServiceValidationRuleInterface::class
        );

        $this->app->bind(TicketEventServicesValidatorInterface::class,
            static function (Application $app) {
                return new TicketEventServicesValidator(
                    $app->make(ServiceRepositoryInterface::class),
                    $app->tagged(TicketEventServiceValidationRuleInterface::class)
                );
            }
        );

        $this->app->tag(
            [
                TicketCreatedNotificationResolver::class,
            ],
            TicketNotificationResolverInterface::class
        );

        $this->app->bind(TicketNotificationResolverFactoryInterface::class,
            static function (Application $app) {
                return new TicketNotificationResolverFactory($app->tagged(TicketNotificationResolverInterface::class));
            }
        );
    }
}
