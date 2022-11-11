<?php

use App\Http\Controllers\API\Analytics\AnalyticFolderController;
use App\Http\Controllers\API\Authentication\LogoutController;
use App\Http\Controllers\API\BackendUsers\BackendUsersTicketAndNotificationCountsController;
use App\Http\Controllers\API\Clients\ClientEDMController;
use App\Http\Controllers\API\Clients\ClientFileListController;
use App\Http\Controllers\API\Clients\ClientFileListV2Controller;
use App\Http\Controllers\API\Clients\ClientTicketAndNotificationCountsController;
use App\Http\Controllers\API\Clients\CreateTicketSupportByClientController;
use App\Http\Controllers\API\Clients\ListClientUsersController;
use App\Http\Controllers\API\Clients\MarkUserAsOwnerController;
use App\Http\Controllers\API\Clients\UpdateClientScreensController;
use App\Http\Controllers\API\ClientServices\ListClientServiceController;
use App\Http\Controllers\API\ClientServices\UpdateClientServiceController;
use App\Http\Controllers\API\Departments\AddDepartmentMembersController;
use App\Http\Controllers\API\Departments\CreateDepartmentController;
use App\Http\Controllers\API\Departments\DeleteDepartmentController;
use App\Http\Controllers\API\Departments\DeleteDepartmentMemberController;
use App\Http\Controllers\API\Departments\DepartmentMembersController;
use App\Http\Controllers\API\Departments\DepartmentStaffsController;
use App\Http\Controllers\API\Departments\DepartmentStaffsListController;
use App\Http\Controllers\API\Departments\ListDepartmentController;
use App\Http\Controllers\API\Departments\ListDepartmentTicketsController;
use App\Http\Controllers\API\Departments\ShowDepartmentController;
use App\Http\Controllers\API\Departments\UpdateDepartmentController;
use App\Http\Controllers\API\Events\CalendarEventsController;
use App\Http\Controllers\API\Events\CreateEventController;
use App\Http\Controllers\API\Events\DeleteEventController;
use App\Http\Controllers\API\Events\ListEventController;
use App\Http\Controllers\API\Events\ShowEventController;
use App\Http\Controllers\API\Events\UpdateEventController;
use App\Http\Controllers\API\Events\UploadFileEventController;
use App\Http\Controllers\API\FileFeedbacks\CreateFileFeedbackController;
use App\Http\Controllers\API\FileFeedbacks\DeleteFileFeedbackController;
use App\Http\Controllers\API\FileFeedbacks\ListFileFeedbackController;
use App\Http\Controllers\API\FileFeedbacks\UpdateFileFeedbackController;
use App\Http\Controllers\API\Folders\CreateFolderController;
use App\Http\Controllers\API\Folders\DeleteFolderController;
use App\Http\Controllers\API\Folders\UpdateFolderController;
use App\Http\Controllers\API\Folders\UploadFileFolderController;
use App\Http\Controllers\API\Graphics\CreateGraphicRequestController;
use App\Http\Controllers\API\Graphics\ListClientGraphicTicketsController;
use App\Http\Controllers\API\InboundEmail\InboundEmailReceiverController;
use App\Http\Controllers\API\Libraries\ClientCreateLibraryTicketController;
use App\Http\Controllers\API\Libraries\CreateLibraryController;
use App\Http\Controllers\API\Libraries\DeleteLibraryController;
use App\Http\Controllers\API\Libraries\ListClientLibraryTicketsController;
use App\Http\Controllers\API\Libraries\ListLibraryController;
use App\Http\Controllers\API\Libraries\ShowLibraryController;
use App\Http\Controllers\API\Libraries\UpdateLibraryController;
use App\Http\Controllers\API\LibraryCategories\CreateLibraryCategoryController;
use App\Http\Controllers\API\LibraryCategories\DeleteLibraryCategoryController;
use App\Http\Controllers\API\LibraryCategories\ListLibraryCategoryController;
use App\Http\Controllers\API\LibraryCategories\ShowLibraryCategoryController;
use App\Http\Controllers\API\LibraryCategories\UpdateLibraryCategoryController;
use App\Http\Controllers\API\Authentication\LoginAsClientController;
use App\Http\Controllers\API\Authentication\LoginController;
use App\Http\Controllers\API\Authentication\RefreshTokenController;
use App\Http\Controllers\API\MarketingPlanners\CreateMarketingPlannerController;
use App\Http\Controllers\API\MarketingPlanners\DeleteMarketingPlannerController;
use App\Http\Controllers\API\MarketingPlanners\ListMarketingPlannerController;
use App\Http\Controllers\API\MarketingPlanners\RemoveMarketingPlannerTaskController;
use App\Http\Controllers\API\MarketingPlanners\ShowMarketingPlannerController;
use App\Http\Controllers\API\MarketingPlanners\UpdateMarketingPlannerController;
use App\Http\Controllers\API\Notifications\NotificationDeleteController;
use App\Http\Controllers\API\Notifications\NotificationDeleteAllController;
use App\Http\Controllers\API\Notifications\NotificationMarkAllAsReadController;
use App\Http\Controllers\API\Notifications\NotificationMarkAsReadController;
use App\Http\Controllers\API\Notifications\UserNotificationListController;
use App\Http\Controllers\API\Photographers\PhotographerStaffsController;
use App\Http\Controllers\API\PrinterJobs\AcceptOfferPrinterJobController;
use App\Http\Controllers\API\PrinterJobs\AssignPricePrinterJobController;
use App\Http\Controllers\API\PrinterJobs\AssignPrinterJobController;
use App\Http\Controllers\API\PrinterJobs\ChangeStatusPrinterJobController;
use App\Http\Controllers\API\PrinterJobs\CreatePrinterJobsController;
use App\Http\Controllers\API\PrinterJobs\DeclinedOfferPrinterJobController;
use App\Http\Controllers\API\PrinterJobs\DeletePrinterJobController;
use App\Http\Controllers\API\PrinterJobs\ListPrinterJobController;
use App\Http\Controllers\API\PrinterJobs\RemoveAttachmentsPrinterJobController;
use App\Http\Controllers\API\PrinterJobs\ShowPrinterJobController;
use App\Http\Controllers\API\PrinterJobs\UpdatePrinterJobController;
use App\Http\Controllers\API\Printers\CreatePrinterController;
use App\Http\Controllers\API\Printers\DeletePrinterController;
use App\Http\Controllers\API\Printers\ListPrinterController;
use App\Http\Controllers\API\Printers\ListPrinterJobsByPrinterController;
use App\Http\Controllers\API\Printers\ShowPrinterController;
use App\Http\Controllers\API\Printers\UpdatePrinterController;
use App\Http\Controllers\API\Screens\CreateScreenController;
use App\Http\Controllers\API\Screens\DeleteScreenController;
use App\Http\Controllers\API\Screens\ListScreenController;
use App\Http\Controllers\API\Screens\ShowScreenController;
use App\Http\Controllers\API\Screens\UpdateScreenController;
use App\Http\Controllers\API\Services\ListServiceController;
use App\Http\Controllers\API\Services\UpdateServiceExtrasController;
use App\Http\Controllers\API\SocialMedia\AllowedMentionUsersListController;
use App\Http\Controllers\API\SocialMedia\CreateSocialMediaCommentController;
use App\Http\Controllers\API\SocialMedia\DeleteSocialMediaCommentController;
use App\Http\Controllers\API\SocialMedia\UpdateSocialMediaCommentController;
use App\Http\Controllers\API\SocialMedia\CreateSocialMediaController;
use App\Http\Controllers\API\SocialMedia\ListSocialMediaController;
use App\Http\Controllers\API\SocialMedia\DeleteSocialMediaController;
use App\Http\Controllers\API\SocialMedia\RemoveAttachmentsSocialMediaController;
use App\Http\Controllers\API\SocialMedia\ShowSocialMediaController;
use App\Http\Controllers\API\SocialMedia\SocialMediaMonthlyListController;
use App\Http\Controllers\API\SocialMedia\UpdateSocialMediaController;
use App\Http\Controllers\API\SupportRequests\CreateSupportRequestController;
use App\Http\Controllers\API\TicketAssignees\ListMyTicketController;
use App\Http\Controllers\API\TicketAssignees\RemoveTicketAssigneeController;
use App\Http\Controllers\API\TicketAssignees\ShowTicketAssigneeController;
use App\Http\Controllers\API\TicketAssignees\UpdateTicketAssigneeController;
use App\Http\Controllers\API\TicketFiles\ApproveTicketFileController;
use App\Http\Controllers\API\TicketFiles\DeleteTicketFileController;
use App\Http\Controllers\API\TicketFiles\GetTicketFileController;
use App\Http\Controllers\API\TicketFiles\ListTicketFilesController;
use App\Http\Controllers\API\TicketFiles\ReplaceTicketFileController;
use App\Http\Controllers\API\TicketFiles\UploadTicketFileController;
use App\Http\Controllers\API\TicketNotes\CreateTicketNoteController;
use App\Http\Controllers\API\TicketNotes\DeleteTicketNoteController;
use App\Http\Controllers\API\TicketNotes\ListTicketNotesController;
use App\Http\Controllers\API\TicketNotes\UpdateTicketNoteController;
use App\Http\Controllers\API\Tickets\CreateEventTicketController;
use App\Http\Controllers\API\TicketEmails\ListTicketEmailController;
use App\Http\Controllers\API\TicketAssignees\TicketAssignStaffsController;
use App\Http\Controllers\API\TicketEmails\TicketEmailMarkAsReadController;
use App\Http\Controllers\API\Tickets\ListTicketActivitiesController;
use App\Http\Controllers\API\Tickets\ShowTicketsByAdminUserController;
use App\Http\Controllers\API\Tickets\TicketAnalyticsController;
use App\Http\Controllers\API\Tickets\TicketAssigneeListController;
use App\Http\Controllers\API\Users\CreateAdminUserController;
use App\Http\Controllers\API\Users\CreateClientUserController;
use App\Http\Controllers\API\Tickets\CreateTicketSupportController;
use App\Http\Controllers\API\Users\CreateLeadClientController;
use App\Http\Controllers\API\Users\DeleteUserController;
use App\Http\Controllers\API\Users\ForgotPasswordController;
use App\Http\Controllers\API\Users\ListAdminUserController;
use App\Http\Controllers\API\Users\NewUserSetPasswordController;
use App\Http\Controllers\API\Users\ResentEmailVerificationController;
use App\Http\Controllers\API\Users\ResetPasswordController;
use App\Http\Controllers\API\Users\RevokeUserController;
use App\Http\Controllers\API\Users\ShowAdminUserController;
use App\Http\Controllers\API\Users\UpdateUserController;
use App\Http\Controllers\API\Users\VerifyUserController;
use App\Http\Controllers\API\Clients\CreateClientController;
use App\Http\Controllers\API\Clients\UpdateClientController;
use App\Http\Controllers\API\Clients\ListClientController;
use App\Http\Controllers\API\Clients\DeleteClientController;
use App\Http\Controllers\API\Clients\ShowClientController;
use App\Http\Controllers\API\Tickets\DeleteTicketController;
use App\Http\Controllers\API\Tickets\UpdateTicketController;
use App\Http\Controllers\API\Tickets\ShowTicketController;
use App\Http\Controllers\API\Tickets\ListTicketSupportController;
use App\Http\Controllers\API\Tickets\ListClientTicketController;
use App\Http\Controllers\API\TicketEmails\CreateTicketEmailController;
use App\Http\Controllers\API\Websites\ListClientWebsiteTicketsController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization, *');

Route::get('/', function () {
    return [
        "data" => [
            "message" => "indy-app-api",
            "code" => 200,
            "error" => false,
        ],
    ];
});

Route::post('/post/receive-email', [
    'uses' => InboundEmailReceiverController::class,
])->name('post-receive-email');

Route::post('/authenticate', [
    'uses' => LoginController::class,
])->name('authenticate');

Route::post('/refresh-token', [
    'as' => 'refresh-token',
    'uses' => RefreshTokenController::class,
]);

Route::post('/new-user-password', [
    'as' => 'new-user-password',
    'uses' => NewUserSetPasswordController::class,
]);

Route::post('/logout', [
    'as' => 'logout',
    'uses' => LogoutController::class,
]);

Route::post('/forgot-password', [
    'as' => 'forgot-password',
    'uses' => ForgotPasswordController::class,
]);
Route::put('/reset-password', [
    'as' => 'reset-password',
    'uses' => ResetPasswordController::class,
]);
Route::get('v1/verify-email', [
    'as' => 'verify-email',
    'uses' => VerifyUserController::class,
]);

Route::post('v1/send-email-verification', [
    'as' => 'resent-email-verification',
    'uses' => ResentEmailVerificationController::class,
]);

Route::post('/client-user/{id}/generate-token', [
    'uses' => LoginAsClientController::class,
]);

Route::get('v1/notifications', [
    'uses' => UserNotificationListController::class,
]);

Route::post('/signup/client-lead', [
    'uses' => CreateLeadClientController::class,
])->name('signup.client-lead');

Route::group([
    'middleware' => 'auth:api',
    'as' => 'crm.api.v2.',
    'prefix' => 'v2',
], function ($router) {
    Route::group([
        'middleware' => ['checkUserStatus'],
        'as' => 'clients.',
        'prefix' => '',
    ], function ($router) {
        Route::get('/clients/{id}/files', [
            'as' => 'files',
            'uses' => ClientFileListV2Controller::class,
        ])->middleware('checkPermission:clients,read');
    });
});

Route::group([
    'middleware' => 'auth:api',
    'as' => 'crm.api.v1.',
    'prefix' => 'v1',
], function ($router) {
    Route::post('/notifications/{id}/mark-as-read', [
        'as' => 'notification-mark-as-read',
        'uses' => NotificationMarkAsReadController::class,
    ]);

    Route::delete('/notifications/{id}', [
        'as' => 'delete-user-notification',
        'uses' => NotificationDeleteController::class,
    ]);

    Route::delete('/notifications', [
        'as' => 'delete-user-notifications',
        'uses' => NotificationDeleteAllController::class,
    ]);

    Route::post('/notifications/mark-as-read', [
        'as' => 'notification-mark-all-as-read',
        'uses' => NotificationMarkAllAsReadController::class,
    ]);

    Route::group([
        'middleware' => ['checkUserStatus'],
        'as' => 'users.',
        'prefix' => '',
    ], function ($router) {
        Route::get('/users', [
            'as' => 'list',
            'uses' => ListAdminUserController::class,
        ])->middleware('checkPermission:users,read');

        Route::post('/users/admin', [
            'as' => 'create-admin',
            'uses' => CreateAdminUserController::class,
        ])->middleware('checkPermission:users,create');

        Route::post('/users/client', [
            'as' => 'create-client',
            'uses' => CreateClientUserController::class,
        ])->middleware('checkPermission:users,create');

        Route::put('/users/{id}/revoke', [
            'as' => 'revoke',
            'uses' => RevokeUserController::class,
        ])->middleware('checkPermission:users,edit');

        Route::put('/users/{id}', [
            'as' => 'update',
            'uses' => UpdateUserController::class,
        ])->middleware('checkPermission:users,edit');
        Route::delete('/users/{id}', [
            'as' => 'delete',
            'uses' => DeleteUserController::class,
        ])->middleware('checkPermission:users,delete');
    });

    Route::get('/backend-users/ticket-notification-counts', [
        'as' => 'backend-users-ticket-notification-counts',
        'uses' => BackendUsersTicketAndNotificationCountsController::class,
    ])->middleware('checkPermission:backend-users,ticket-notification-counts');



    Route::group([
        'middleware' => ['checkUserStatus'],
        'as' => 'clients.',
        'prefix' => '',
    ], function ($router) {
        Route::post('/clients', [
            'as' => 'create',
            'uses' => CreateClientController::class,
        ])->middleware('checkPermission:clients,create');

        Route::put('/clients/{id}', [
            'as' => 'update',
            'uses' => UpdateClientController::class,
        ])->middleware('checkPermission:clients,edit');

        Route::put('/clients/{id}/owner', [
            'as' => 'client.owner',
            'uses' => MarkUserAsOwnerController::class,
        ])->middleware('checkPermission:clients,edit');

        Route::get('/clients/{id}/libraries', [
            'as' => 'libraries-tickets',
            'uses' => ListClientLibraryTicketsController::class,
        ])->middleware('checkPermission:clients,read');

        Route::get('/clients/{id}/websites', [
            'as' => 'websites-tickets',
            'uses' => ListClientWebsiteTicketsController::class,
        ])->middleware('checkPermission:clients,read');

        Route::get('/clients', [
            'as' => 'list',
            'uses' => ListClientController::class,
        ])->middleware('checkPermission:clients,read');

        Route::delete('/clients/{id}', [
            'as' => 'delete',
            'uses' => DeleteClientController::class,
        ])->middleware('checkPermission:clients,delete');

        Route::get('/clients/{id}', [
            'as' => 'show',
            'uses' => ShowClientController::class,
        ])->middleware('checkPermission:clients,read');

        Route::get('/clients/{id}/tickets', [
            'as' => 'tickets',
            'uses' => ListClientTicketController::class,
        ])->middleware('checkPermission:clients,read');

        Route::get('/clients/{id}/files', [
            'as' => 'files',
            'uses' => ClientFileListController::class,
        ])->middleware('checkPermission:clients,read');

        Route::get('/clients/{id}/analytics-folder', [
            'as' => 'analytics-folder',
            'uses' => AnalyticFolderController::class,
        ])->middleware('checkPermission:clients,read');

        Route::get('/clients/{id}/users', [
            'as' => 'users',
            'uses' => ListClientUsersController::class,
        ])->middleware('checkPermission:clients,read');

        Route::get('/clients/{id}/services', [
            'as' => 'services',
            'uses' => ListClientServiceController::class,
        ])->middleware('checkPermission:client-services,read');

        Route::put('/clients/{id}/services', [
            'as' => 'update-services',
            'uses' => UpdateClientServiceController::class,
        ])->middleware('checkPermission:client-services,edit');

        Route::post('/clients/{id}/folders', [
            'as' => 'create.folder',
            'uses' => CreateFolderController::class,
        ]);
        Route::put('/clients/{id}/screens', [
            'as' => 'update.screens',
            'uses' => UpdateClientScreensController::class,
        ]);

        Route::put('/folders/{id}', [
            'as' => 'update.folder',
            'uses' => UpdateFolderController::class,
        ]);

        Route::delete('/folders/{id}', [
            'as' => 'delete.folder',
            'uses' => DeleteFolderController::class,
        ]);

        Route::post('/folders/{id}/upload-files', [
            'as' => 'upload.folder',
            'uses' => UploadFileFolderController::class,
        ]);

        Route::post('/support-request', [
            'as' => 'create-support-request',
            'uses' => CreateSupportRequestController::class,
        ])->middleware('checkPermission:clients,support-request');

        Route::get('/clients/{id}/marketing-planners', [
            'as' => 'marketing-planner.list',
            'uses' => ListMarketingPlannerController::class,
        ])->middleware('checkPermission:marketing-planner,create');

        Route::post('/clients/{id}/marketing-planners', [
            'as' => 'marketing-planner.create',
            'uses' => CreateMarketingPlannerController::class,
        ])->middleware('checkPermission:marketing-planner,create');


        Route::delete('/marketing-planner-tasks/{id}', [
            'as' => 'marketing-planner-task.delete',
            'uses' => RemoveMarketingPlannerTaskController::class,
        ])->middleware('checkPermission:marketing-planner,edit');


        Route::put('/marketing-planners/{id}', [
            'as' => 'marketing-planner.update',
            'uses' => UpdateMarketingPlannerController::class,
        ])->middleware('checkPermission:marketing-planner,edit');

        Route::get('/marketing-planners/{id}', [
            'as' => 'marketing-planner.view',
            'uses' => ShowMarketingPlannerController::class,
        ])->middleware('checkPermission:marketing-planner,edit');

        Route::delete('/marketing-planners/{id}', [
            'as' => 'marketing-planner.delete',
            'uses' => DeleteMarketingPlannerController::class,
        ])->middleware('checkPermission:marketing-planner,edit');

        Route::get('/clients/{id}/edm', [
            'as' => 'edm',
            'uses' => ClientEDMController::class,
        ])->middleware('checkPermission:clients,read');

        Route::post('/clients/{id}/event-bookings', [
            'as' => 'event-booking.create',
            'uses' => CreateEventController::class,
        ])->middleware('checkPermission:clients,read');

        Route::get('/clients/{id}/event-calendar-bookings', [
            'as' => 'event-booking.calendar',
            'uses' => CalendarEventsController::class,
        ])->middleware('checkPermission:clients,read');

        Route::get('/clients/{id}/social-media-calendar', [
            'as' => 'social-media.calendar',
            'uses' => SocialMediaMonthlyListController::class,
        ])->middleware('checkPermission:clients,read');

        Route::get('/clients/{id}/social-media-users', [
            'as' => 'social-media.users',
            'uses' => AllowedMentionUsersListController::class,
        ])->middleware('checkPermission:clients,read');

        Route::get('/clients/{id}/event-bookings', [
            'as' => 'event-booking.list',
            'uses' => ListEventController::class,
        ])->middleware('checkPermission:clients,read');

        Route::get('/event-bookings/{id}', [
            'as' => 'event-booking.show',
            'uses' => ShowEventController::class,
        ])->middleware('checkPermission:clients,read');

        Route::post('/event-bookings/{id}/upload-files', [
            'as' => 'event-booking.upload',
            'uses' => UploadFileEventController::class,
        ])->middleware('checkPermission:clients,read');

        Route::put('/event-bookings/{id}', [
            'as' => 'event-booking.update',
            'uses' => UpdateEventController::class,
        ])->middleware('checkPermission:clients,read');

        Route::delete('/event-bookings/{id}', [
            'as' => 'event-booking.delete',
            'uses' => DeleteEventController::class,
        ])->middleware('checkPermission:clients,read');
    });

    Route::group([
        'middleware' => ['checkUserStatus'],
        'as' => 'tickets.',
        'prefix' => '',
    ], function ($router) {
        Route::post('/tickets', [
            'as' => 'support-create',
            'uses' => CreateTicketSupportController::class,
        ])->middleware('checkPermission:tickets,create');

        Route::post('/tickets/{id}/assign', [
            'as' => 'assign-staffs',
            'uses' => TicketAssignStaffsController::class,
        ])->middleware('checkPermission:tickets,assign');

        Route::delete('/ticket-assignees/{id}', [
            'as' => 'remove-assignee',
            'uses' => RemoveTicketAssigneeController::class,
        ])->middleware('checkPermission:tickets,assign');

        Route::get('/tickets/{id}/assignees', [
            'as' => 'staff-assigned',
            'uses' => TicketAssigneeListController::class,
        ])->middleware('checkPermission:tickets,read');

        Route::get('/ticket-assignees/{id}', [
            'as' => 'show-assignee',
            'uses' => ShowTicketAssigneeController::class,
        ])->middleware('checkPermission:tickets,read');

        Route::put('/ticket-assignees/{id}', [
            'as' => 'update-assignee-status',
            'uses' => UpdateTicketAssigneeController::class,
        ])->middleware('checkPermission:tickets,assign');

        Route::get('/my-tickets', [
            'as' => 'list-my-tickets',
            'uses' => ListMyTicketController::class,
        ])->middleware('checkPermission:my-tickets,read');

        Route::put('/tickets/{id}', [
            'as' => 'update',
            'uses' => UpdateTicketController::class,
        ])->middleware('checkPermission:tickets,edit');

        Route::post('/tickets/event', [
            'as' => 'event-create',
            'uses' => CreateEventTicketController::class,
        ])->middleware('checkPermission:tickets,create-event');

        Route::delete('/tickets/{id}', [
            'as' => 'delete',
            'uses' => DeleteTicketController::class,
        ])->middleware('checkPermission:tickets,delete');

        Route::get('/tickets', [
            'as' => 'list',
            'uses' => ListTicketSupportController::class,
        ])->middleware('checkPermission:tickets,read');

        Route::get('/tickets/{id}', [
            'as' => 'show',
            'uses' => ShowTicketController::class,
        ])->middleware('checkPermission:tickets,read');

        Route::get('/tickets/{id}/activities', [
            'as' => 'activities-list',
            'uses' => ListTicketActivitiesController::class,
        ])->middleware('checkPermission:tickets,read');

        Route::post('/tickets/{id}/notes', [
            'as' => 'create-notes',
            'uses' => CreateTicketNoteController::class,
        ])->middleware('checkPermission:tickets,create-note');

        Route::get('/tickets/{id}/notes', [
            'as' => 'list-notes',
            'uses' => ListTicketNotesController::class,
        ])->middleware('checkPermission:tickets,read');

        Route::delete('/ticket-notes/{id}', [
            'as' => 'delete-notes',
            'uses' => DeleteTicketNoteController::class,
        ])->middleware('checkPermission:tickets,delete');

        Route::put('/ticket-notes/{id}', [
            'as' => 'update-notes',
            'uses' => UpdateTicketNoteController::class,
        ])->middleware('checkPermission:tickets,edit');

    });

    Route::group([
        'middleware' => ['checkUserStatus'],
        'as' => 'departments.',
        'prefix' => '',
    ], function ($router) {
        Route::get('/departments/staff-list', [
            'as' => 'with-staffs',
            'uses' => DepartmentStaffsController::class,
        ])->middleware('checkPermission:departments,read-staffs');
        Route::post('/departments', [
            'as' => 'create',
            'uses' => CreateDepartmentController::class,
        ])->middleware('checkPermission:departments,create');

        Route::put('/departments/{id}', [
            'as' => 'update',
            'uses' => UpdateDepartmentController::class,
        ])->middleware('checkPermission:departments,edit');

        Route::get('/departments/{id}', [
            'as' => 'show',
            'uses' => ShowDepartmentController::class,
        ])->middleware('checkPermission:departments,read');

        Route::delete('/departments/{id}', [
            'as' => 'delete',
            'uses' => DeleteDepartmentController::class,
        ])->middleware('checkPermission:departments,delete');

        Route::get('/departments', [
            'as' => 'list',
            'uses' => ListDepartmentController::class,
        ])->middleware('checkPermission:departments,read');

        Route::get('/departments/{id}/tickets', [
            'as' => 'ticket-list',
            'uses' => ListDepartmentTicketsController::class,
        ])->middleware('checkPermission:department-tickets,read');

        Route::get('/departments/{id}/ticket-counts', [
            'uses' => TicketAnalyticsController::class,
            'as' => 'ticket-counts'
        ])->middleware('checkPermission:department-tickets,read');

        Route::post('/departments/{id}/members', [
            'as' => 'add-members',
            'uses' => AddDepartmentMembersController::class,
        ])->middleware('checkPermission:departments,add-members');

        Route::get('/departments/{id}/members', [
            'as' => 'get-members',
            'uses' => DepartmentMembersController::class,
        ])->middleware('checkPermission:departments,read-members');
        Route::delete('/departments/{id}/members', [
            'as' => 'delete-members',
            'uses' => DeleteDepartmentMemberController::class,
        ])->middleware('checkPermission:departments,remove-members');

        Route::get('/departments/{id}/staffs', [
            'as' => 'get-staffs',
            'uses' => DepartmentStaffsListController::class,
        ])->middleware('checkPermission:departments,read-members');

        Route::get('/photographers', [
            'as' => 'photographers',
            'uses' => PhotographerStaffsController::class,
        ])->middleware('checkPermission:departments,read');
    });

    Route::group([
        'middleware' => ['checkUserStatus'],
        'as' => 'ticket-emails.',
        'prefix' => '',
    ], function ($router) {
        Route::post('/tickets/{id}/emails', [
            'as' => 'email-create',
            'uses' => CreateTicketEmailController::class,
        ])->middleware('checkPermission:ticket-emails,create');

        Route::get('/tickets/{id}/emails', [
            'as' => 'email-list',
            'uses' => ListTicketEmailController::class,
        ])->middleware('checkPermission:ticket-emails,read');

        Route::put('/tickets/{id}/emails/mark-as-read', [
            'as' => 'email-update',
            'uses' => TicketEmailMarkAsReadController::class,
        ])->middleware('checkPermission:tickets,edit');
    });

    Route::group([
        'middleware' => ['checkUserStatus'],
        'as' => 'file-feedbacks.',
        'prefix' => '',
    ], function ($router) {
        Route::post('/ticket-files/{id}/feedbacks', [
            'as' => 'feedback-create',
            'uses' => CreateFileFeedbackController::class,
        ])->middleware('checkPermission:file-feedbacks,create');

        Route::get('/ticket-files/{id}/feedbacks', [
            'as' => 'file-feedback-list',
            'uses' => ListFileFeedbackController::class,
        ])->middleware('checkPermission:file-feedbacks,read');

        Route::put('/ticket-files/feedback/{id}', [
            'as' => 'update',
            'uses' => UpdateFileFeedbackController::class,
        ])->middleware('checkPermission:file-feedbacks,edit');

        Route::delete('/ticket-files/feedback/{id}', [
            'as' => 'delete',
            'uses' => DeleteFileFeedbackController::class,
        ])->middleware('checkPermission:file-feedbacks,delete');
    });


    Route::group([
        'middleware' => ['checkUserStatus'],
        'as' => 'ticket-files.',
        'prefix' => '',
    ], function ($router) {
        Route::post('/tickets/{id}/upload-file', [
            'as' => 'upload',
            'uses' => UploadTicketFileController::class,
        ])->middleware('checkPermission:ticket-files,create');

        Route::get('/ticket-files/{id}', [
            'as' => 'show',
            'uses' => GetTicketFileController::class,
        ])->middleware('checkPermission:ticket-files,read');

        Route::delete('/ticket-files/{id}', [
            'as' => 'delete',
            'uses' => DeleteTicketFileController::class,
        ])->middleware('checkPermission:ticket-files,delete');

        Route::post('/ticket-files/{id}/approve', [
            'as' => 'approve',
            'uses' => ApproveTicketFileController::class,
        ])->middleware('checkPermission:ticket-files,approval');

        Route::get('/tickets/{id}/files', [
            'as' => 'files-list',
            'uses' => ListTicketFilesController::class,
        ])->middleware('checkPermission:ticket-files,read');

        Route::post('/ticket-files/{id}/replace-file', [
            'as' => 'replace-file',
            'uses' => ReplaceTicketFileController::class,
        ])->middleware('checkPermission:ticket-files,edit');
    });

    Route::group([
        'middleware' => ['checkUserStatus'],
        'as' => 'libraries.',
        'prefix' => '',
    ], function ($router) {
        Route::post('/libraries', [
            'as' => 'create',
            'uses' => CreateLibraryController::class,
        ])->middleware('checkPermission:library-categories,create');

        Route::get('/libraries/{id}', [
            'as' => 'show',
            'uses' => ShowLibraryController::class,
        ])->middleware('checkPermission:library-categories,read');

        Route::get('/libraries', [
            'as' => 'list',
            'uses' => ListLibraryController::class,
        ])->middleware('checkPermission:library-categories,read');

        Route::put('/libraries/{id}', [
            'as' => 'update',
            'uses' => UpdateLibraryController::class,
        ])->middleware('checkPermission:library-categories,edit');

        Route::delete('/libraries/{id}', [
            'as' => 'delete',
            'uses' => DeleteLibraryController::class,
        ])->middleware('checkPermission:library-categories,delete');

        Route::post('/libraries/{id}/ticket', [
            'as' => 'create-ticket',
            'uses' => ClientCreateLibraryTicketController::class,
        ])->middleware('checkPermission:library-ticket,create');
    });

    Route::group([
        'middleware' => ['checkUserStatus'],
        'as' => 'graphics.',
        'prefix' => '',
    ], function ($router) {
        Route::post('/graphics', [
            'as' => 'create-graphic-ticket',
            'uses' => CreateGraphicRequestController::class,
        ])->middleware('checkPermission:graphics,request-create');

        Route::get('/clients/{id}/graphics', [
            'as' => 'list-graphic-ticket',
            'uses' => ListClientGraphicTicketsController::class,
        ])->middleware('checkPermission:tickets,read');

        Route::get('/clients/{id}/ticket-notification-counts', [
            'as' => 'client-ticket-notification-counts',
            'uses' => ClientTicketAndNotificationCountsController::class,
        ])->middleware('checkPermission:tickets,read');
    });

    Route::group([
        'middleware' => ['checkUserStatus'],
        'as' => 'library-categories.',
        'prefix' => '',
    ], function ($router) {
        Route::post('/library-categories', [
            'as' => 'create',
            'uses' => CreateLibraryCategoryController::class,
        ])->middleware('checkPermission:library-categories,create');

        Route::get('/library-categories/{id}', [
            'as' => 'show',
            'uses' => ShowLibraryCategoryController::class,
        ])->middleware('checkPermission:library-categories,read');

        Route::get('/library-categories', [
            'as' => 'list',
            'uses' => ListLibraryCategoryController::class,
        ])->middleware('checkPermission:library-categories,read');

        Route::delete('/library-categories/{id}', [
            'as' => 'destroy',
            'uses' => DeleteLibraryCategoryController::class,
        ])->middleware('checkPermission:library-categories,delete');

        Route::put('/library-categories/{id}', [
            'as' => 'update',
            'uses' => UpdateLibraryCategoryController::class,
        ])->middleware('checkPermission:library-categories,edit');
    });

    Route::group([
        'middleware' => ['checkUserStatus'],
        'as' => 'printers.',
        'prefix' => '',
    ], function ($router) {
        Route::post('/printers', [
            'as' => 'create',
            'uses' => CreatePrinterController::class,
        ])->middleware('checkPermission:library-categories,create');
        Route::get('/printers', [
            'as' => 'list',
            'uses' => ListPrinterController::class,
        ])->middleware('checkPermission:library-categories,create');

        Route::get('/printers/{id}', [
            'as' => 'show',
            'uses' => ShowPrinterController::class,
        ])->middleware('checkPermission:library-categories,create');

        Route::delete('/printers/{id}', [
            'as' => 'delete',
            'uses' => DeletePrinterController::class,
        ])->middleware('checkPermission:library-categories,create');

        Route::get('/printers/{id}/printer-jobs', [
            'as' => 'printer-jobs',
            'uses' => ListPrinterJobsByPrinterController::class,
        ])->middleware('checkPermission:library-categories,create');
        Route::put('/printers/{id}', [
            'as' => 'update',
            'uses' => UpdatePrinterController::class,
        ])->middleware('checkPermission:library-categories,read');

        Route::put('/printers/{id}/approve-offer', [
            'as' => 'accept=offer',
            'uses' => AcceptOfferPrinterJobController::class,
        ])->middleware('checkPermission:library-categories,read');

        Route::put('/printers/{id}/decline-offer', [
            'as' => 'decline-offer',
            'uses' => DeclinedOfferPrinterJobController::class,
        ])->middleware('checkPermission:library-categories,read');
    });

    Route::group([
        'middleware' => ['checkUserStatus'],
        'as' => 'social-media.',
        'prefix' => '',
    ], function ($router) {
        Route::post('clients/{id}/social-media', [
            'as' => 'create',
            'uses' => CreateSocialMediaController::class,
        ]);
        Route::get('clients/{id}/social-media', [
            'as' => 'list',
            'uses' => ListSocialMediaController::class,
        ]);
        Route::get('/social-media/{id}', [
            'as' => 'show',
            'uses' => ShowSocialMediaController::class,
        ]);
        Route::put('/social-media/{id}', [
            'as' => 'update',
            'uses' => UpdateSocialMediaController::class,
        ]);
        Route::delete('/social-media/{id}', [
            'as' => 'delete',
            'uses' => DeleteSocialMediaController::class,
        ]);
        Route::put('/social-media/{id}/attachments', [
            'as' => 'delete-attachments',
            'uses' => RemoveAttachmentsSocialMediaController::class,
        ]);
        Route::post('/social-media/{id}/comments', [
            'as' => 'create-comments',
            'uses' => CreateSocialMediaCommentController::class,
        ]);
        Route::put('/social-media-comments/{id}', [
            'as' => 'update-comments',
            'uses' => UpdateSocialMediaCommentController::class,
        ]);
        Route::delete('/social-media-comments/{id}', [
            'as' => 'delete-comments',
            'uses' => DeleteSocialMediaCommentController::class,
        ]);
    });

    Route::group([
        'middleware' => ['checkUserStatus'],
        'as' => 'services.',
        'prefix' => '',
    ], function ($router) {
        Route::get('/services', [
            'as' => 'list',
            'uses' => ListServiceController::class,
        ])->middleware('checkPermission:services,read');
        Route::put('/services/{id}', [
            'as' => 'update',
            'uses' => UpdateServiceExtrasController::class,
        ])->middleware('checkPermission:services,update');
    });

    Route::group([
        'middleware' => ['checkUserStatus'],
        'as' => 'printer-jobs.',
        'prefix' => '',
    ], function ($router) {
        Route::post('clients/{id}/printer-jobs', [
            'as' => 'create',
            'uses' => CreatePrinterJobsController::class,
        ]);
        Route::get('clients/{id}/printer-jobs', [
            'as' => 'list',
            'uses' => ListPrinterJobController::class,
        ]);
        Route::get('printer-jobs/{id}', [
            'as' => 'show',
            'uses' => ShowPrinterJobController::class,
        ]);
        Route::put('printer-jobs/{id}', [
            'as' => 'update',
            'uses' => UpdatePrinterJobController::class,
        ]);
        Route::delete('printer-jobs/{id}', [
            'as' => 'delete',
            'uses' => DeletePrinterJobController::class,
        ]);
        Route::put('printer-jobs/{id}/change-status', [
            'as' => 'update-status',
            'uses' => ChangeStatusPrinterJobController::class,
        ]);
        Route::put('printer-jobs/{id}/assign-printer', [
            'as' => 'update-assignee',
            'uses' => AssignPrinterJobController::class,
        ]);
        Route::put('printer-jobs/{id}/assign-price', [
            'as' => 'update-price',
            'uses' => AssignPricePrinterJobController::class,
        ])->middleware('checkPermission:printer-jobs,assign-price');;
        Route::put('/printer-jobs/{id}/attachments', [
            'as' => 'delete-attachments',
            'uses' => RemoveAttachmentsPrinterJobController::class,
        ]);
    });

    Route::group([
        'middleware' => ['checkUserStatus'],
        'as' => 'screens.',
        'prefix' => '',
    ], function ($router) {
        Route::post('screens', [
            'as' => 'create',
            'uses' => CreateScreenController::class,
        ]);
        Route::get('screens', [
            'as' => 'list',
            'uses' => ListScreenController::class,
        ]);
        Route::get('screens/{id}', [
            'as' => 'show',
            'uses' => ShowScreenController::class,
        ]);
        Route::delete('screens/{id}', [
            'as' => 'delete',
            'uses' => DeleteScreenController::class,
        ]);
        Route::put('screens/{id}', [
            'as' => 'update',
            'uses' => UpdateScreenController::class,
        ]);
    });
    Route::group([
        'middleware' => ['checkUserStatus'],
        'as' => 'admin-users.',
        'prefix' => '',
    ], function ($router) {

        Route::get('admin-users/{id}', [
            'as' => 'show',
            'uses' => ShowAdminUserController::class,
        ]);

        Route::get('admin-users/{id}/tickets', [
            'as' => 'tickets',
            'uses' => ShowTicketsByAdminUserController::class,
        ]);
    });

    /* ---- End of File --- */
});


