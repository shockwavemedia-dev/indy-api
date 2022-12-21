<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public const TABLE = 'printers';

    public function up(): void
    {
        if (Schema::hasTable(self::TABLE) === true) {
            return;
        }

        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->unique();
            $table->string('contact_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('description')->nullable();
            $table->bigInteger('file_id')->unsigned()->nullable();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('file_id');
            $table->foreign('file_id')->references('id')->on('files');
            $table->index('created_by');
            $table->foreign('created_by')->references('id')->on('users');
            $table->index('updated_by');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE);
    }
};
