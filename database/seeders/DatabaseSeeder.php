<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        $this->call([
            FilesTableSeeder::class,
            LibraryCategoriesTableSeeder::class,
            LibrariesTableSeeder::class,
            UsersTableSeeder::class,
            DepartmentsSeeder::class,
            ServicesSeeder::class,
        ]);

        if (Config::get('app.demo_server') === false) {
            return;
        }


        $this->call(MigrationsTableSeeder::class);
        $this->call(PasswordResetsTableSeeder::class);
        $this->call(OauthAuthCodesTableSeeder::class);
        $this->call(OauthRefreshTokensTableSeeder::class);
        $this->call(OauthClientsTableSeeder::class);
        $this->call(OauthPersonalAccessClientsTableSeeder::class);
        $this->call(FailedJobsTableSeeder::class);
        $this->call(PersonalAccessTokensTableSeeder::class);
        $this->call(AdminUsersTableSeeder::class);
        $this->call(ClientUsersTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        $this->call(TicketEmailAttachmentsTableSeeder::class);
        $this->call(FileFeedbacksTableSeeder::class);
        $this->call(FileFeedbackAttachmentsTableSeeder::class);
        $this->call(JobsTableSeeder::class);
        $this->call(ServicesTableSeeder::class);
        $this->call(ClientServicesTableSeeder::class);
        $this->call(LeadClientsTableSeeder::class);
        $this->call(TicketEventAttachmentsTableSeeder::class);
        $this->call(TicketEventsTableSeeder::class);
        $this->call(TicketActivitiesTableSeeder::class);
        $this->call(TicketEmailsTableSeeder::class);
        $this->call(EmailLogsTableSeeder::class);
        $this->call(DepartmentServicesTableSeeder::class);
        $this->call(TicketAssigneeLinksTableSeeder::class);
        $this->call(ErrorLogsTableSeeder::class);
        $this->call(SupportRequestsTableSeeder::class);
        $this->call(SupportRequestChatsTableSeeder::class);
        $this->call(NotificationsTableSeeder::class);
        $this->call(TicketAssigneesTableSeeder::class);
        $this->call(NotificationUsersTableSeeder::class);
        $this->call(FoldersTableSeeder::class);
        $this->call(MarketingPlannerAttachmentsTableSeeder::class);
        $this->call(OauthAccessTokensTableSeeder::class);
        $this->call(EventsTableSeeder::class);
        $this->call(MarketingPlannersTableSeeder::class);
        $this->call(PrintersTableSeeder::class);
        $this->call(MailboxInboundEmailsTableSeeder::class);
        $this->call(SocialMediaAttachmentsTableSeeder::class);
        $this->call(SocialMediaActivitiesTableSeeder::class);
        $this->call(SocialMediaCommentsTableSeeder::class);
        $this->call(AuditsTableSeeder::class);
        $this->call(SocialMediaTableSeeder::class);
        $this->call(MarketingPlannerTaskAssigneesTableSeeder::class);
        $this->call(MarketingPlannerTasksTableSeeder::class);
        $this->call(ScreensTableSeeder::class);
        $this->call(ClientScreensTableSeeder::class);
        $this->call(AdminDepartmentsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ClientTicketFilesTableSeeder::class);
        $this->call(PrinterJobAttachmentsTableSeeder::class);
        $this->call(PrinterJobsTableSeeder::class);
        $this->call(ClientsTableSeeder::class);
        $this->call(TicketFileVersionsTableSeeder::class);
        $this->call(TicketNotesTableSeeder::class);
        $this->call(TicketsTableSeeder::class);
        $this->call(FilesTableSeeder::class);
        $this->call(TicketChatsTableSeeder::class);
        $this->call(NoteAttachmentsTableSeeder::class);
        $this->call(TicketServicesTableSeeder::class);
        $this->call(LibraryCategoriesTableSeeder::class);
        $this->call(LibrariesTableSeeder::class);
    }
}
