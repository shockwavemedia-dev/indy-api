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
        Schema::create('social_media_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('social_media_id');
            $table->string('old_value');
            $table->string('new_value');
            $table->unsignedBigInteger('created_by');

            $table->index('created_by');
            $table->index('social_media_id');

            $table->foreign('social_media_id')->references('id')->on('social_media');
            $table->foreign('created_by')->references('id')->on('users');
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
        Schema::dropIfExists('social_media_activities');
    }
};
