<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateTicketEventAttachmentsTable extends Migration
{
    private const TABLE = 'ticket_event_attachments';

    public function up(): void
    {
        if (Schema::hasTable(self::TABLE) === true) {
            return;
        }

        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->bigInteger('file_id')->unsigned();
            $table->bigInteger('ticket_event_id')->unsigned();

            $table->index('file_id');
            $table->foreign('file_id')->references('id')->on('files');

            $table->index('ticket_event_id');
            $table->foreign('ticket_event_id')->references('id')->on('ticket_events');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE);
    }
}
