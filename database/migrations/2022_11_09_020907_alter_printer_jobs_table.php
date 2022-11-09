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
        Schema::table('printer_jobs', function (Blueprint $table) {
            $table->string('stocks')->nullable();
            $table->string('coding')->nullable();
            $table->string('address')->nullable();
            $table->string('purchase_order_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('printer_jobs', function (Blueprint $table) {
            $table->dropColumn('stocks');
            $table->dropColumn('coding');
            $table->dropColumn('address');
            $table->dropColumn('purchase_order_number');
        });
    }
};
