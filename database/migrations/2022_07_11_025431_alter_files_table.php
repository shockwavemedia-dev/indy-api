<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class AlterFilesTable extends Migration
{
    private const TABLE = 'files';

    public function up(): void
    {
        if (Schema::hasColumn(self::TABLE, 'folder_id') === true) {
            return;
        }

        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->unsignedBigInteger('folder_id')->nullable()->after('file_name');

            $table->index('folder_id');
            $table->foreign('folder_id')->references('id')->on('folders');
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn(self::TABLE, 'folder_id') === false) {
            return;
        }

        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->dropForeign('files_folder_id_foreign');
            $table->dropColumn('folder_id');
        });
    }
}
