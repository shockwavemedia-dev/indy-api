<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Commands;

use App\Http\Controllers\API\AbstractAPIController;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

final class CreateDBSeederFromCurrentStateController extends AbstractAPIController
{
    public function __invoke(): JsonResource
    {
        if ($this->getUser()?->getEmail() !== 'superadmin@indy.com.au') {
            return $this->respondNoContent();
        }

        if (Config::get('app.demo_server') === false) {
            return $this->respondBadRequest(['message' => 'Invalid server to backup']);
        }

        Artisan::call('php artisan iseed migrations,password_resets,oauth_auth_codes,oauth_refresh_tokens,oauth_clients,oauth_personal_access_clients,failed_jobs,personal_access_tokens,admin_users,client_users,departments,ticket_email_attachments,file_feedbacks,file_feedback_attachments,jobs,services,client_services,library_categories,libraries,lead_clients,ticket_event_attachments,ticket_events,ticket_activities,ticket_emails,email_logs,department_services,ticket_assignee_links,error_logs,support_requests,support_request_chats,notifications,ticket_assignees,notification_users,folders,marketing_planner_attachments,oauth_access_tokens,events,marketing_planners,printers,mailbox_inbound_emails,social_media_attachments,social_media_activities,social_media_comments,audits,social_media,marketing_planner_task_assignees,marketing_planner_tasks,screens,client_screens,admin_departments,users,client_ticket_files,printer_job_attachments,printer_jobs,clients,ticket_file_versions,ticket_notes,tickets,files,ticket_chats,note_attachments,ticket_services --force');

        return new JsonResource(['data' => Artisan::output()]);
    }
}
