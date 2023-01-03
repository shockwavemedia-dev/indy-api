<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateTicketEmailsTable extends Migration
{
    public const TABLE = 'ticket_emails';

    public function up(): void
    {
        if (Schema::hasTable(self::TABLE) === true) {
            return;
        }

        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('ticket_id');
            $table->string('cc')->nullable()->default(null);
            $table->longText('message');
            $table->string('status');
            $table->unsignedBigInteger('sender_by');
            $table->string('sender_type');
            $table->unsignedTinyInteger('is_read')->default('0');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('updated_by');
            $table->index('client_id');
            $table->index('ticket_id');
            $table->foreign('sender_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('ticket_id')->references('id')->on('tickets');
        });
    }

    public function down()
    {
        Schema::dropIfExists(self::TABLE);
    }
}
