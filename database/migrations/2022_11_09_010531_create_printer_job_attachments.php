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
        Schema::create('printer_job_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('printer_job_id');
            $table->unsignedBigInteger('file_id');
            $table->index('printer_job_id');
            $table->index('file_id');

            $table->foreign('printer_job_id')->references('id')->on('printer_jobs');
            $table->foreign('file_id')->references('id')->on('files');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('printer_job_attachments');
    }
};
