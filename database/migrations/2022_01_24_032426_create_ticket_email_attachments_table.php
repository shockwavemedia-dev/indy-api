<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateTicketEmailAttachmentsTable extends Migration
{
    public const TABLE = 'ticket_email_attachments';

    public function up(): void
    {
        if (Schema::hasTable(self::TABLE) === true) {
            return;
        }

        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_email_id');
            $table->unsignedBigInteger('file_id');
            $table->timestamps();

            $table->index('ticket_email_id');
            $table->index('file_id');

            $table->foreign('ticket_email_id')->references('id')->on('ticket_emails');
            $table->foreign('file_id')->references('id')->on('files');
        });
    }

    public function down()
    {
        Schema::dropIfExists(self::TABLE);
    }
}
