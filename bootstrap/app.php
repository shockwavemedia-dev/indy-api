<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

use App\Providers\BackendUserNotificationServiceProvider;
use App\Providers\ClientServiceProvider;
use App\Providers\ClientServiceServiceProvider;
use App\Providers\DepartmentServiceProvider;
use App\Providers\EmailLogServiceProvider;
use App\Providers\ErrorServiceProvider;
use App\Providers\EventBookingServiceProvider;
use App\Providers\FileManagerServiceProvider;
use App\Providers\FileServiceProvider;
use App\Providers\FolderServiceProvider;
use App\Providers\GraphicServiceProvider;
use App\Providers\LibraryCategoryServiceProvider;
use App\Providers\LibraryServiceProvider;
use App\Providers\MailChimpServiceProvider;
use App\Providers\MarketingPlannerServiceProvider;
use App\Providers\NotificationServiceProvider;
use App\Providers\OptimusServiceProvider;
use App\Providers\PrinterJobServiceProvider;
use App\Providers\PrinterServiceProvider;
use App\Providers\RedisServiceProvider;
use App\Providers\RepositoryServiceProvider;
use App\Providers\ScreenServiceProvider;
use App\Providers\SlackServiceProvider;
use App\Providers\SmsServiceProvider;
use App\Providers\SocialMediaServiceProvider;
use App\Providers\SortingServiceProvider;
use App\Providers\SupportRequestServiceProvider;
use App\Providers\TicketAssigneeLinkServiceProvider;
use App\Providers\TicketServiceProvider;
use App\Providers\UserServiceProvider;
use App\Providers\TicketEmailServiceProvider;
use App\Providers\FileFeedbackServiceProvider;
use App\Providers\FileFeedbackAttachmentServiceProvider;

$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->register(BackendUserNotificationServiceProvider::class);
$app->register(ClientServiceProvider::class);
$app->register(ClientServiceServiceProvider::class);
$app->register(DepartmentServiceProvider::class);
$app->register(EventBookingServiceProvider::class);
$app->register(EmailLogServiceProvider::class);
$app->register(ErrorServiceProvider::class);
$app->register(FileFeedbackServiceProvider::class);
$app->register(FileFeedbackAttachmentServiceProvider::class);
$app->register(FileManagerServiceProvider::class);
$app->register(FileServiceProvider::class);
$app->register(FolderServiceProvider::class);
$app->register(GraphicServiceProvider::class);
$app->register(LibraryServiceProvider::class);
$app->register(LibraryCategoryServiceProvider::class);
$app->register(MailChimpServiceProvider::class);
$app->register(MarketingPlannerServiceProvider::class);
$app->register(NotificationServiceProvider::class);
$app->register(OptimusServiceProvider::class);
$app->register(PrinterServiceProvider::class);
$app->register(RedisServiceProvider::class);
$app->register(RepositoryServiceProvider::class);
$app->register(SlackServiceProvider::class);
$app->register(SmsServiceProvider::class);
$app->register(SocialMediaServiceProvider::class);
$app->register(SortingServiceProvider::class);
$app->register(SupportRequestServiceProvider::class);
$app->register(TicketAssigneeLinkServiceProvider::class);
$app->register(TicketServiceProvider::class);
$app->register(TicketEmailServiceProvider::class);
$app->register(UserServiceProvider::class);
$app->register(PrinterJobServiceProvider::class);
$app->register(ScreenServiceProvider::class);

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;
