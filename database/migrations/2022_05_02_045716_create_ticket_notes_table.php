<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateTicketNotesTable extends Migration
{
    /**
     * @var string
     */
    private const TABLE = 'ticket_notes';

    public function up(): void
    {
        if (Schema::hasTable(self::TABLE) === true) {
            return;
        }

        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->json('note');
            $table->bigInteger('ticket_id')->unsigned();
            $table->bigInteger('created_by')->unsigned();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('ticket_id');
            $table->foreign('ticket_id')->references('id')->on('tickets');

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
}
