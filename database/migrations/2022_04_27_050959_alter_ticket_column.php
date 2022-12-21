<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

final class AlterTicketColumn extends Migration
{
    /**
     * @var string
     */
    private const TABLE = 'tickets';

    public function up(): void
    {
        if (Schema::hasTable(self::TABLE) === false) {
            return;
        }

        $counts = DB::table(self::TABLE)->count();

        if ($counts > 0) {
            DB::update("UPDATE tickets set description = '{}'");
        }

        if (
            env('DB_CONNECTION') !== 'sqlite' &&
            env('DB_CONNECTION') !== 'mysql' &&
            env('DB_CONNECTION') !== null
        ) {
            DB::statement('ALTER TABLE tickets ALTER COLUMN description TYPE json USING description::json;');
        } else {
            Schema::table(self::TABLE, function (Blueprint $table) {
                $table->json('description')->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        // Do nothing
    }
}
