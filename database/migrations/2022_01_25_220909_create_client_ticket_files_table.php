<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateClientTicketFilesTable extends Migration
{
    public const TABLE = 'client_ticket_files';

    public function up() : void
    {
        if (Schema::hasTable(self::TABLE) === true) {
            return;
        }

        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('file_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('ticket_id');
            $table->string('status')->nullable()->default(null);
            $table->longText('description')->nullable()->default(null);
            $table->unsignedBigInteger('admin_user_id')->nullable()->default(null);
            $table->unsignedBigInteger('approved_by')->nullable()->default(null);
            $table->dateTime('approved_at')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();

            $table->index('file_id');
            $table->index('client_id');
            $table->index('ticket_id');
            $table->index('admin_user_id');
            $table->index('approved_by');

            $table->foreign('file_id')->references('id')->on('files');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('ticket_id')->references('id')->on('tickets');
            $table->foreign('admin_user_id')->references('id')->on('users');
            $table->foreign('approved_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE);
    }
}
