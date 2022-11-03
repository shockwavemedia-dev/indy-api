<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateTicketsTable extends Migration
{
    public const TABLE = 'tickets';

    public function up() : void
    {
        if (Schema::hasTable(self::TABLE) === true) {
            return;
        }

        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->string('ticket_code');
            $table->dateTime('duedate')->nullable()->default(null);
            $table->string('subject');
            $table->string('description');
            $table->string('type');
            $table->string('status');
            $table->string('created_by_user_type');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('requested_by');
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('client_id');
            $table->index('created_by');
            $table->index('updated_by');
            $table->index('requested_by');
            $table->index('deleted_by');
            $table->index('department_id');

            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('requested_by')->references('id')->on('users');
            $table->foreign('deleted_by')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists(self::TABLE);
    }
}
