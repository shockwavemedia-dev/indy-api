<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class AlterTicketAssigneesTableAddColumn extends Migration
{
    /**
     * @var string
     */
    private const TABLE = 'ticket_assignees';

    public function up(): void
    {
        if (Schema::hasColumn(self::TABLE, 'created_by') === true) {
            return;
        }

        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->bigInteger('created_by')
                ->unsigned()
                ->default(0)
                ->after("status");

            $table->index('created_by');
            $table->foreign('created_by')->references('id')->on('admin_users');

        });
    }

    public function down(): void
    {
        if (Schema::hasColumn(self::TABLE,'created_by') === false) {
            return;
        }

        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->dropForeign("ticket_assignees_created_by_foreign");
            $table->dropColumn('created_by');
        });
    }
}
