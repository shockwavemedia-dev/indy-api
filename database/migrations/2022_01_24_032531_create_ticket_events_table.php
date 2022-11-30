<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketEventsTable extends Migration
{
    public const TABLE = 'ticket_events';

    public function up(): void
    {
        if (Schema::hasTable(self::TABLE) === true) {
            return;
        }

        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_id');
            $table->dateTime('duedate')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();

            $table->index('ticket_id');
            $table->foreign('ticket_id')->references('id')->on('tickets');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE);
    }
}
