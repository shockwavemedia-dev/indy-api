<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateFileFeedbacksTable extends Migration
{
    public const TABLE = 'file_feedbacks';

    public function up() : void
    {
        if (Schema::hasTable(self::TABLE) === true) {
            return;
        }

        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_file_id');
            $table->unsignedBigInteger('feedback_by');
            $table->string('feedback_by_type');
            $table->longText('feedback');
            $table->timestamps();
            $table->softDeletes();

            $table->index('client_file_id');
            $table->index('feedback_by');
            $table->foreign('client_file_id')->references('id')->on('client_ticket_files');
            $table->foreign('feedback_by')->references('id')->on('users');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE);
    }
}
