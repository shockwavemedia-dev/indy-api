<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateMarketingPlannerTasksTable extends Migration
{
    public const TABLE = 'marketing_planner_tasks';

    public function up(): void
    {
        if (Schema::hasTable(self::TABLE) === true) {
            return;
        }

        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('marketing_planner_id');
            $table->string('name');
            $table->string('assignee');
            $table->string('status');
            $table->date('deadline');
            $table->timestamps();

            $table->index('marketing_planner_id');
            $table->foreign('marketing_planner_id')->references('id')->on('marketing_planners');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(self::TABLE);
    }
}
