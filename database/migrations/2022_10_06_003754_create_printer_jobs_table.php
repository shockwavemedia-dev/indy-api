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
        Schema::create('printer_jobs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('printer_id')->nullable();
            $table->string('status')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('product')->nullable();
            $table->string('option')->nullable();
            $table->string('kinds')->nullable();
            $table->string('quantity')->nullable();
            $table->string('run_ons')->nullable();
            $table->string('format')->nullable();
            $table->json('final_trim_size')->nullable();
            $table->string('reference')->nullable();
            $table->string('notes')->nullable();
            $table->json('additional_options')->nullable();
            $table->string('delivery')->nullable();
            $table->string('price')->nullable();
            $table->smallInteger('blind_shipping')->nullable()->default(0);
            $table->smallInteger('reseller_samples')->nullable()->default(0);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('printer_id')->references('id')->on('printers');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('printer_jobs');
    }
};
