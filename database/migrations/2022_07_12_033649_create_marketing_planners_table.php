<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateMarketingPlannersTable extends Migration
{
    private const TABLE = 'marketing_planners';

    public function up(): void
    {
        if (Schema::hasTable(self::TABLE) === true) {
            return;
        }

        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->string('event_name');
            $table->json('description')->nullable();
            $table->json('todo_list')->nullable();
            $table->json('task_management')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->smallInteger('is_recurring');
            $table->unsignedBigInteger('created_by');
            $table->index('created_by');
            $table->foreign('created_by')->references('id')->on('users');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->index('updated_by');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE);
    }
}
