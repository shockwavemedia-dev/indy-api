<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

final class AlterTicketEmailsMessageToJson extends Migration
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

        $counts = DB::table(self::TABLE)->count();

        if ($counts > 0) {
            DB::update("UPDATE ticket_emails set message = '{}'");
        }

        if (
            env('DB_CONNECTION') !== 'sqlite' &&
            env('DB_CONNECTION') !== 'mysql' &&
            env('DB_CONNECTION') !== null
        ) {
            DB::statement('ALTER TABLE ticket_emails ALTER COLUMN message TYPE json USING message::json;');
        } else {
            Schema::table(self::TABLE, function (Blueprint $table) {
                $table->json('message')->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        // Do nothing
    }
}
