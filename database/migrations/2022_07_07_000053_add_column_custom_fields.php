<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class AddColumnCustomFields extends Migration
{
    /**
     * @var string
     */
    private const TABLE = 'ticket_services';

    public function up(): void
    {
        if (Schema::hasColumn(self::TABLE, 'custom_fields') === true) {
            return;
        }

        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->json('custom_fields')->nullable();
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn(self::TABLE, 'custom_fields') === false) {
            return;
        }

        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->dropColumn('custom_fields');
        });
    }
}
