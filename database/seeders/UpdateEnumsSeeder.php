<?php

namespace Database\Seeders;

use App\Enum\AdminRoleEnum;
use App\Enum\ClientRoleEnum;
use App\Enum\TicketAssigneeStatusEnum;
use App\Enum\TicketFileStatusEnum;
use App\Enum\UserStatusEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class UpdateEnumsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('admin_users')
            ->where('admin_role', 'account_manager')
            ->update(['admin_role' => AdminRoleEnum::ACCOUNT_MANAGER]);

        DB::table('client_users')
            ->where('client_role', 'marketing_manager')
            ->update(['client_role' => ClientRoleEnum::MARKETING_MANAGER]);

        DB::table('client_users')
            ->where('client_role', 'group_manager')
            ->update(['client_role' => ClientRoleEnum::GROUP_MANAGER]);

        DB::table('users')
            ->where('status', 'not_verified')
            ->update(['status' => UserStatusEnum::INVITED]);

        DB::table('ticket_assignees')
            ->where('status', 'in_progress')
            ->update(['status' => TicketAssigneeStatusEnum::IN_PROGRESS]);


        DB::table('client_ticket_files')
            ->where('status', 'in_progress')
            ->update(['status' => TicketFileStatusEnum::IN_PROGRESS]);

        DB::table('client_ticket_files')
            ->where('status', 'for review')
            ->update(['status' => TicketFileStatusEnum::FOR_REVIEW]);
    }
}
