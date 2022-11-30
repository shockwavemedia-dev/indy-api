<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class AlterFilesAddColumnBucket extends Migration
{
    /**
     * @var string
     */
    public const TABLE = 'files';

    public function up(): void
    {
        if (Schema::hasTable(self::TABLE) === false) {
            return;
        }

        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->string('bucket')->nullable()->after('file_name');
        });
    }

    public function down(): void
    {
        if (Schema::hasTable(self::TABLE) === false) {
            return;
        }

        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->dropColumn('bucket');
        });
    }
}
