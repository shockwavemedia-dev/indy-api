<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class AddColumnToFilesTable extends Migration
{
    /**
     * @var string
     */
    private const TABLE = 'files';

    public function up(): void
    {
        if (Schema::hasColumn(self::TABLE, 'thumbnail_url') === true) {
            return;
        }

        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->longText('thumbnail_url')->nullable()->after('url');
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn(self::TABLE, 'thumbnail_url') === false) {
            return;
        }

        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->dropColumn('thumbnail_url');
        });
    }
}
