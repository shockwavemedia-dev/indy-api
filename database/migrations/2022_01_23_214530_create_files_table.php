<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateFilesTable extends Migration
{
    public const TABLE = 'files';

    public function up() : void
    {
        if (Schema::hasTable(self::TABLE) === true) {
            return;
        }

        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->string('original_filename');
            $table->string('file_size');
            $table->string('file_type');
            $table->string('file_path');
            $table->string('disk');
            $table->string('version')->default(1);
            $table->longText('url')->nullable()->default(null);
            $table->dateTime('url_expiration')->nullable()->default(null);
            $table->unsignedBigInteger('uploaded_by');
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('uploaded_by');
            $table->index('deleted_by');
            $table->foreign('uploaded_by')->references('id')->on('users');
            $table->foreign('deleted_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE);
    }
}
