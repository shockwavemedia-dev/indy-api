<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('marketing_planner_task_assignees') === true) {
            return;
        }

        Schema::create('marketing_planner_task_assignees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('user_id');
            $table->string('status')->nullable();
            $table->timestamp('deadline')->nullable();
            $table->timestamps();

            $table->foreign('task_id')->references('id')->on('marketing_planner_tasks');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('marketing_planner_tasks', function (Blueprint $table) {
            $table->string('assignee')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marketing_planner_task_assignees');
    }
};
