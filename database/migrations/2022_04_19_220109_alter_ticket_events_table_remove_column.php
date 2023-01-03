<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class AlterTicketEventsTableRemoveColumn extends Migration
{
    /**
     * @var string
     */
    private const TABLE = 'ticket_events';

    public function up(): void
    {
        if (Schema::hasColumn(self::TABLE, 'attachment_id') === false) {
            return;
        }

        Schema::table(self::TABLE, function (Blueprint $table) {
            if (env('DB_CONNECTION') !== 'sqlite') {
                $table->dropForeign('ticket_events_attachment_id_foreign');
            }

            $table->dropColumn('attachment_id');
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn(self::TABLE, 'attachment_id') === true) {
            return;
        }

        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->bigInteger('attachment_id')->unsigned()->nullable();
            $table->index('attachment_id');
            $table->foreign('attachment_id')->references('id')->on('files');
        });
    }
}
