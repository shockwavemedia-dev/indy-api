<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\AdminUserRepository;
use App\Repositories\ClientRepository;
use App\Repositories\ClientServiceRepository;
use App\Repositories\ClientTicketFileRepository;
use App\Repositories\ClientUserRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\EmailLogRepository;
use App\Repositories\ErrorLogRepository;
use App\Repositories\EventRepository;
use App\Repositories\FeedbackAttachmentRepository;
use App\Repositories\FileRepository;
use App\Repositories\FolderRepository;
use App\Repositories\Interfaces\AdminUserRepositoryInterface;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Repositories\Interfaces\ClientServiceRepositoryInterface;
use App\Repositories\Interfaces\ClientTicketFileRepositoryInterface;
use App\Repositories\Interfaces\ClientUserRepositoryInterface;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Repositories\Interfaces\EloquentRepositoryInterface;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\EmailLogRepositoryInterface;
use App\Repositories\Interfaces\ErrorLogRepositoryInterface;
use App\Repositories\Interfaces\EventRepositoryInterface;
use App\Repositories\Interfaces\FileFeedbackAttachmentRepositoryInterface;
use App\Repositories\Interfaces\FileRepositoryInterface;
use App\Repositories\Interfaces\FolderRepositoryInterface;
use App\Repositories\Interfaces\LeadClientRepositoryInterface;
use App\Repositories\Interfaces\LibraryCategoryRepositoryInterface;
use App\Repositories\Interfaces\LibraryRepositoryInterface;
use App\Repositories\Interfaces\MarketingPlannerAttachmentRepositoryInterface;
use App\Repositories\Interfaces\MarketingPlannerRepositoryInterface;
use App\Repositories\Interfaces\MarketingPlannerTaskAssigneeRepositoryInterface;
use App\Repositories\Interfaces\MarketingPlannerTaskRepositoryInterface;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use App\Repositories\Interfaces\NotificationUserRepositoryInterface;
use App\Repositories\Interfaces\PrinterJobAttachmentRepositoryInterface;
use App\Repositories\Interfaces\PrinterJobRepositoryInterface;
use App\Repositories\Interfaces\PrinterRepositoryInterface;
use App\Repositories\Interfaces\ScreenRepositoryInterface;
use App\Repositories\Interfaces\ServiceRepositoryInterface;
use App\Repositories\Interfaces\SocialMediaActivityRepositoryInterface;
use App\Repositories\Interfaces\SocialMediaAttachmentRepositoryInterface;
use App\Repositories\Interfaces\SocialMediaCommentRepositoryInterface;
use App\Repositories\Interfaces\SocialMediaRepositoryInterface;
use App\Repositories\Interfaces\SupportRequestRepositoryInterface;
use App\Repositories\Interfaces\TicketActivityRepositoryInterface;
use App\Repositories\Interfaces\TicketAssigneeLinkRepositoryInterface;
use App\Repositories\Interfaces\TicketAssigneeRepositoryInterface;
use App\Repositories\Interfaces\TicketEventAttachmentRepositoryInterface;
use App\Repositories\Interfaces\TicketEventRepositoryInterface;
use App\Repositories\Interfaces\TicketServiceRepositoryInterface;
use App\Repositories\Interfaces\TicketNoteRepositoryInterface;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\LeadClientRepository;
use App\Repositories\LibraryCategoryRepository;
use App\Repositories\LibraryRepository;
use App\Repositories\MarketingPlannerAttachmentRepository;
use App\Repositories\MarketingPlannerRepository;
use App\Repositories\MarketingPlannerTaskAssigneeRepository;
use App\Repositories\MarketingPlannerTaskRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\NotificationUserRepository;
use App\Repositories\PrinterJobAttachmentRepository;
use App\Repositories\PrinterJobRepository;
use App\Repositories\PrinterRepository;
use App\Repositories\ScreenRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\SocialMediaActivityRepository;
use App\Repositories\SocialMediaAttachmentRepository;
use App\Repositories\SocialMediaCommentRepository;
use App\Repositories\SocialMediaRepository;
use App\Repositories\SupportRequestRepository;
use App\Repositories\TicketActivityRepository;
use App\Repositories\TicketAssigneeLinkRepository;
use App\Repositories\TicketAssigneeRepository;
use App\Repositories\TicketEventAttachmentRepository;
use App\Repositories\TicketEventRepository;
use App\Repositories\Interfaces\TicketEmailRepositoryInterface;
use App\Repositories\Interfaces\FileFeedbackRepositoryInterface;
use App\Repositories\TicketServiceRepository;
use App\Repositories\TicketNoteRepository;
use App\Repositories\TicketRepository;
use App\Repositories\UserRepository;
use App\Repositories\TicketEmailRepository;
use App\Repositories\FileFeedbackRepository;
use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoryServiceProvider
 * @package App\Providers
 */
final class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $repositories = [
            AdminUserRepositoryInterface::class => AdminUserRepository::class,
            ClientRepositoryInterface::class => ClientRepository::class,
            ClientTicketFileRepositoryInterface::class => ClientTicketFileRepository::class,
            ClientServiceRepositoryInterface::class => ClientServiceRepository::class,
            ClientUserRepositoryInterface::class => ClientUserRepository::class,
            DepartmentRepositoryInterface::class => DepartmentRepository::class,
            EloquentRepositoryInterface::class => BaseRepository::class,
            EmailLogRepositoryInterface::class => EmailLogRepository::class,
            ErrorLogRepositoryInterface::class => ErrorLogRepository::class,
            EventRepositoryInterface::class => EventRepository::class,
            FileFeedbackRepositoryInterface::class => FileFeedbackRepository::class,
            FileFeedbackAttachmentRepositoryInterface::class => FeedbackAttachmentRepository::class,
            FileRepositoryInterface::class => FileRepository::class,
            FolderRepositoryInterface::class => FolderRepository::class,
            LeadClientRepositoryInterface::class => LeadClientRepository::class,
            LibraryRepositoryInterface::class => LibraryRepository::class,
            LibraryCategoryRepositoryInterface::class => LibraryCategoryRepository::class,
            MarketingPlannerRepositoryInterface::class => MarketingPlannerRepository::class,
            MarketingPlannerAttachmentRepositoryInterface::class => MarketingPlannerAttachmentRepository::class,
            MarketingPlannerTaskRepositoryInterface::class => MarketingPlannerTaskRepository::class,
            MarketingPlannerTaskAssigneeRepositoryInterface::class => MarketingPlannerTaskAssigneeRepository::class,
            NotificationRepositoryInterface::class => NotificationRepository::class,
            NotificationUserRepositoryInterface::class => NotificationUserRepository::class,
            PrinterRepositoryInterface::class => PrinterRepository::class,
            PrinterJobRepositoryInterface::class => PrinterJobRepository::class,
            ScreenRepositoryInterface::class => ScreenRepository::class,
            ServiceRepositoryInterface::class => ServiceRepository::class,
            SocialMediaRepositoryInterface::class => SocialMediaRepository::class,
            SocialMediaCommentRepositoryInterface::class => SocialMediaCommentRepository::class,
            SocialMediaActivityRepositoryInterface::class => SocialMediaActivityRepository::class,
            SocialMediaAttachmentRepositoryInterface::class => SocialMediaAttachmentRepository::class,
            SupportRequestRepositoryInterface::class => SupportRequestRepository::class,
            TicketActivityRepositoryInterface::class => TicketActivityRepository::class,
            TicketAssigneeLinkRepositoryInterface::class => TicketAssigneeLinkRepository::class,
            TicketAssigneeRepositoryInterface::class => TicketAssigneeRepository::class,
            TicketNoteRepositoryInterface::class => TicketNoteRepository::class,
            TicketRepositoryInterface::class => TicketRepository::class,
            TicketEmailRepositoryInterface::class =>TicketEmailRepository::class,
            TicketEventAttachmentRepositoryInterface::class => TicketEventAttachmentRepository::class,
            TicketEventRepositoryInterface::class => TicketEventRepository::class,
            TicketServiceRepositoryInterface::class => TicketServiceRepository::class,
            UserRepositoryInterface::class => UserRepository::class,
            PrinterJobAttachmentRepositoryInterface::class => PrinterJobAttachmentRepository::class,
        ];

        foreach ($repositories as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
