<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class AddOwnerIdColumnToClientsTable extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->index('owner_id');
            $table->foreign('owner_id')->references('id')->on('client_users');
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropForeign('clients_owner_id_foreign');
            $table->dropIndex('clients_owner_id_index');
            $table->dropColumn('owner_id');
        });
    }
}
