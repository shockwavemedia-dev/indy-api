<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateMarketingPlannerAttachmentsTable extends Migration
{
    private const TABLE = 'marketing_planner_attachments';

    public function up(): void
    {
        if (Schema::hasTable(self::TABLE) === true) {
            return;
        }

        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->bigInteger('file_id')->unsigned();
            $table->bigInteger('marketing_planner_id')->unsigned();

            $table->index('file_id');
            $table->foreign('file_id')->references('id')->on('files');

            $table->index('marketing_planner_id');
            $table->foreign('marketing_planner_id')->references('id')->on('marketing_planners');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE);
    }
}
