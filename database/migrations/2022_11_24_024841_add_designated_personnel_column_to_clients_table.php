<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->unsignedBigInteger('designated_animator_id')->nullable();
            $table->unsignedBigInteger('designated_web_editor_id')->nullable();
            $table->unsignedBigInteger('designated_social_media_manager_id')->nullable();
            $table->unsignedBigInteger('designated_printer_manager_id')->nullable();

            $table->index('designated_animator_id');
            $table->index('designated_web_editor_id');
            $table->index('designated_social_media_manager_id');
            $table->index('designated_printer_manager_id');

            $table->foreign('designated_animator_id')->references('id')->on('admin_users');
            $table->foreign('designated_web_editor_id')->references('id')->on('admin_users');
            $table->foreign('designated_social_media_manager_id')->references('id')->on('admin_users');
            $table->foreign('designated_printer_manager_id')->references('id')->on('admin_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropForeign('clients_designated_animator_id_foreign');
            $table->dropIndex('clients_designated_animator_id_index');
            $table->dropColumn('designated_animator_id');

            $table->dropForeign('clients_designated_web_editor_id_foreign');
            $table->dropIndex('clients_designated_web_editor_id_index');
            $table->dropColumn('designated_web_editor_id');

            $table->dropForeign('clients_designated_social_media_manager_id_foreign');
            $table->dropIndex('clients_designated_social_media_manager_id_index');
            $table->dropColumn('designated_social_media_manager_id');

            $table->dropForeign('clients_designated_printer_manager_id_foreign');
            $table->dropIndex('clients_designated_printer_manager_id_index');
            $table->dropColumn('designated_printer_manager_id');
        });
    }
};
