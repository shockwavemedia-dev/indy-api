<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class AddPhotographerIdToEventsTable extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->unsignedBigInteger('photographer_id')->nullable();
            $table->index('photographer_id');
            $table->foreign('photographer_id')->references('id')->on('admin_users');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign('events_photographer_id_foreign');
            $table->dropIndex('events_photographer_id_index');
            $table->dropColumn('photographer_id');
        });
    }
}
