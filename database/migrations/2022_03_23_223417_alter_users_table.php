<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class AlterUsersTable extends Migration
{
    /**
     * @var string
     */
    private const TABLE = 'users';

    public function up(): void
    {
        if (Schema::hasTable(self::TABLE) === false) {
            return;
        }

        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->string('first_name')->nullable()->change();
            $table->string('middle_name')->nullable()->change();
            $table->string('last_name')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Do nothing
    }
}
