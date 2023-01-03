<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class AddColumnToTableTicketAssignee extends Migration
{
    /**
     * @var string
     */
    private const TABLE = 'ticket_assignees';

    public function up(): void
    {
        if (Schema::hasColumn(self::TABLE, 'updated_by') === true) {
            return;
        }

        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');

            $table->index('updated_by');
            $table->foreign('updated_by')->references('id')->on('admin_users');
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn(self::TABLE, 'updated_by') === false) {
            return;
        }

        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->dropForeign('ticket_assignees_updated_by_foreign');
            $table->dropColumn('updated_by');
        });
    }
}
