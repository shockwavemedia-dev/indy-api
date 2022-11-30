<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateUsersTable extends Migration
{
    public const TABLE = 'users';

    public function up(): void
    {
        if (Schema::hasTable(self::TABLE) === true) {
            return;
        }

        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->morphs('morphable');
            $table->string('status');
            $table->string('first_name');
            $table->string('middle_name')->nullable()->default(null);
            $table->string('last_name');
            $table->string('contact_number')->nullable()->default(null);
            $table->string('gender')->nullable()->default(null);
            $table->dateTime('birth_date')->nullable()->default(null);
            $table->timestamp('email_verified_at')->nullable()->default(null);
            $table->rememberToken();
            $table->timestamps();

            $table->index('email');
            $table->index(['morphable_id', 'morphable_type']);
        });
    }

    public function down(): void
    {
        if (Schema::hasTable(self::TABLE) === false) {
            return;
        }

        Schema::table(self::TABLE, function (Blueprint $table) {
//            $table->dropMorphs('morphable');
            //files
//            $table->dropForeign('files_uploaded_by_foreign');
//            $table->dropColumn('uploaded_by');
//            $table->dropForeign('files_deleted_by_foreign');
//            $table->dropColumn('deleted_by');
//            //client ticket files
//            $table->dropForeign('client_ticket_files_admin_user_id_foreign');
//            $table->dropColumn('admin_user_id');
//            $table->dropForeign('client_ticket_files_approved_by_foreign');
//            $table->dropColumn('approved_by');
//            //file feedbacks
//            $table->dropForeign('feedback_by_foreign');
//            $table->dropColumn('feedback_by');
//            //tickets
//            $table->dropForeign('tickets_created_by_foreign');
//            $table->dropColumn('created_by');
//            $table->dropForeign('tickets_requested_by_foreign');
//            $table->dropColumn('requested_by');
//            $table->dropForeign('tickets_deleted_by_foreign');
//            $table->dropColumn('deleted_by');
        });

        Schema::dropIfExists(self::TABLE);
    }
}
