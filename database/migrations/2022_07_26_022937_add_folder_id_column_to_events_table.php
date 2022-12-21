<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class AddFolderIdColumnToEventsTable extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->unsignedBigInteger('folder_id')->nullable()->after('client_id');
            $table->index('folder_id');
            $table->foreign('folder_id')->references('id')->on('folders');
            $table->string('start_time')->change();
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign('events_folder_id_foreign');
            $table->dropIndex('events_folder_id_index');
            $table->dropColumn('folder_id');
            $table->time('start_time')->change();
        });
    }
}
