<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateLibrariesTable extends Migration
{
    public const TABLE = 'libraries';

    public function up(): void
    {
        if (Schema::hasTable(self::TABLE) === true) {
            return;
        }

        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->bigInteger('library_category_id')->unsigned();
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('video_link')->nullable();
            $table->bigInteger('file_id')->unsigned()->nullable();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('created_by');
            $table->foreign('created_by')->references('id')->on('users');

            $table->index('library_category_id');
            $table->foreign('library_category_id')->references('id')->on('library_categories');

            $table->index('file_id');
            $table->foreign('file_id')->references('id')->on('files');

            $table->index('updated_by');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE);
    }
}
