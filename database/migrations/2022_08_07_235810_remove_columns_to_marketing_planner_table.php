<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('marketing_planners', 'todo_list') === true) {
            Schema::table('marketing_planners', function (Blueprint $table) {
                $table->dropColumn('todo_list');
            });
        }

        if (Schema::hasColumn('marketing_planners', 'task_management') === true) {
            Schema::table('marketing_planners', function (Blueprint $table) {
                $table->dropColumn('task_management');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('marketing_planners', 'todo_list') === false) {
            Schema::table('marketing_planners', function (Blueprint $table) {
                $table->json('todo_list')->nullable();
            });
        }

        if (Schema::hasColumn('marketing_planners', 'task_management') === false) {
            Schema::table('marketing_planners', function (Blueprint $table) {
                $table->json('task_management')->nullable();
            });
        }
    }
};
