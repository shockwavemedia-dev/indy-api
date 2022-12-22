<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class AlterNotificationUsers extends Migration
{
    /**
     * @var string
     */
    private const TABLE = 'notification_users';

    public function up(): void
    {
        if (Schema::hasColumn(self::TABLE, 'status') === true) {
            return;
        }

        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->string('status')->default('new');
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn(self::TABLE, 'status') === false) {
            return;
        }

        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
