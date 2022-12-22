<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class AddLogoFileIdDesignatedDesignerIdToClientsTable extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->unsignedBigInteger('logo_file_id')->nullable();
            $table->unsignedBigInteger('designated_designer_id')->nullable();

            $table->index('logo_file_id');
            $table->index('designated_designer_id');

            $table->foreign('logo_file_id')->references('id')->on('files');
            $table->foreign('designated_designer_id')->references('id')->on('admin_users');
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropForeign('clients_logo_file_id_foreign');
            $table->dropForeign('clients_designated_designer_id_foreign');

            $table->dropIndex('clients_logo_file_id_index');
            $table->dropIndex('clients_designated_designer_id_index');

            $table->dropColumn('designated_designer_id');
            $table->dropColumn('logo_file_id');
        });
    }
}
