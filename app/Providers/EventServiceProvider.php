<?php

namespace App\Providers;

use App\Models\SupportRequest;
use App\Models\Tickets\ClientTicketFile;
use App\Models\Tickets\FileFeedback;
use App\Models\Tickets\Ticket;
use App\Models\Tickets\TicketAssignee;
use App\Models\Tickets\TicketEmail;
use App\Models\Tickets\TicketService;
use App\Observers\ClientTicketFileObserver;
use App\Observers\FileFeedbackObserver;
use App\Observers\SupportRequestObserver;
use App\Observers\TicketAssigneeObserver;
use App\Observers\TicketEmailObserver;
use App\Observers\TicketObserver;
use App\Observers\TicketServiceObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {
        ClientTicketFile::observe(ClientTicketFileObserver::class);
        FileFeedback::observe(FileFeedbackObserver::class);
        SupportRequest::observe(SupportRequestObserver::class);
        TicketAssignee::observe(TicketAssigneeObserver::class);
        Ticket::observe(TicketObserver::class);
        TicketEmail::observe(TicketEmailObserver::class);
        TicketService::observe(TicketServiceObserver::class);
    }
}
