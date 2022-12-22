<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class AlterTicketsTable extends Migration
{
    private const TABLE = 'tickets';

    public function up(): void
    {
        if (Schema::hasColumn(self::TABLE, 'marketing_planner_id') === true) {
            return;
        }

        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->unsignedBigInteger('marketing_planner_id')->nullable()->after('client_id');
            $table->smallInteger('is_marketing_planner')->default(0)->after('status');

            $table->index('marketing_planner_id');
            $table->foreign('marketing_planner_id')->references('id')->on('marketing_planners');
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn(self::TABLE, 'marketing_planner_id') === false) {
            return;
        }

        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->dropForeign('tickets_marketing_planner_id_foreign');
            $table->dropColumn('marketing_planner_id');
            $table->dropColumn('is_marketing_planner');
        });
    }
}
