<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateTicketAssigneesTable extends Migration
{
    public const TABLE = 'ticket_assignees';

    public function up(): void
    {
        if (Schema::hasTable(self::TABLE) === true) {
            return;
        }

        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_id');
            $table->unsignedBigInteger('admin_user_id');
            $table->unsignedBigInteger('department_id');
            $table->string('status');
            $table->timestamps();

            $table->index('ticket_id');
            $table->index('admin_user_id');
            $table->index('department_id');

            $table->foreign('ticket_id')->references('id')->on('tickets');
            $table->foreign('admin_user_id')->references('id')->on('admin_users');
            $table->foreign('department_id')->references('id')->on('departments');
        });
    }

    public function down()
    {
        Schema::dropIfExists(self::TABLE);
    }
}
