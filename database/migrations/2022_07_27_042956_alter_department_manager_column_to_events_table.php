<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class AlterDepartmentManagerColumnToEventsTable extends Migration
{
    public function up(): void
    {
        if (env('DB_CONNECTION') === 'sqlite'){
            return;
        }

        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign('events_department_manager_foreign');
            $table->dropIndex('events_department_manager_index');
            $table->dropColumn('department_manager');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->string('department_manager')->nullable()->after('event_name');
        });
    }

    public function down(): void
    {
        if (env('DB_CONNECTION') === 'sqlite'){
            return;
        }

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('department_manager');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->unsignedBigInteger('department_manager')->nullable();
            $table->index('department_manager');
            $table->foreign('department_manager')->references('id')->on('admin_users');
        });
    }
}
