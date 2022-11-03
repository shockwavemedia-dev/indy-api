<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class AlterTicketEmailsColumn extends Migration
{
    /**
     * @var string
     */
    private const TABLE = 'ticket_emails';

    public function up(): void
    {
        if (Schema::hasTable(self::TABLE) === false) {
            return;
        }

        if (Schema::hasColumn(self::TABLE, 'title') === true) {
            return;
        }

        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->text('title')->nullable()->after("ticket_id");
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn(self::TABLE,'title') === false) {
            return;
        }

        if (env('DB_CONNECTION') === 'sqlite') {
            return;
        }

        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->dropColumn('title');
        });
    }
}
