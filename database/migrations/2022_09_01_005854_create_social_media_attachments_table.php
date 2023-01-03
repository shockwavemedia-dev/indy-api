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
        Schema::create('social_media_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('social_media_id');
            $table->unsignedBigInteger('file_id');
            $table->index('social_media_id');
            $table->index('file_id');

            $table->foreign('social_media_id')->references('id')->on('social_media');
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
        Schema::dropIfExists('social_media_attachments');
    }
};
