<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateFileFeedbackAttachmentsTable extends Migration
{
    public const TABLE = 'file_feedback_attachments';

    public function up(): void
    {
        if (Schema::hasTable(self::TABLE) === true) {
            return;
        }

        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('feedback_id');
            $table->unsignedBigInteger('file_id');
            $table->unsignedBigInteger('client_file_id');
            $table->timestamps();
            $table->softDeletes();

            $table->index('feedback_id');
            $table->index('client_file_id');
            $table->foreign('feedback_id')->references('id')->on('file_feedbacks');
            $table->foreign('file_id')->references('id')->on('files');
            $table->foreign('client_file_id')->references('id')->on('client_ticket_files');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE);
    }
}
