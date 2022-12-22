<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class AlterTableNameTicketServices extends Migration
{
    private const NEW_TABLE = 'ticket_services';

    private const OLD_TABLE = 'ticket_event_services';

    public function up(): void
    {
        if (Schema::hasTable(self::NEW_TABLE) === true) {
            return;
        }

        Schema::create(self::NEW_TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_id');
            $table->unsignedBigInteger('service_id');
            $table->json('extras')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('ticket_id');
            $table->index('service_id');
            $table->index('created_by');
            $table->index('updated_by');

            $table->foreign('ticket_id')->references('id')->on('tickets');
            $table->foreign('service_id')->references('id')->on('services');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });

        Schema::dropIfExists(self::OLD_TABLE);
    }

    public function down(): void
    {
        Schema::dropIfExists(self::NEW_TABLE);

        if (Schema::hasTable(self::OLD_TABLE) === true) {
            return;
        }

        Schema::create(self::OLD_TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_event_id');
            $table->unsignedBigInteger('service_id');
            $table->json('extras')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('ticket_event_id');
            $table->index('service_id');
            $table->index('created_by');
            $table->index('updated_by');

            $table->foreign('ticket_event_id')->references('id')->on('ticket_events');
            $table->foreign('service_id')->references('id')->on('services');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }
}
