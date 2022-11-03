<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateTicketAssigneeLinksTable extends Migration
{
    /**
     * @var string
     */
    private const TABLE = 'ticket_assignee_links';

    public function up(): void
    {
        if (Schema::hasTable(self::TABLE) === true) {
            return;
        }

        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('main_assignee_id');
            $table->text('link_issue');
            $table->unsignedBigInteger('link_assignee_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->softDeletes();
            $table->timestamps();

            $table->index('main_assignee_id');
            $table->foreign('main_assignee_id')->references('id')->on('ticket_assignees');

            $table->index('link_assignee_id');
            $table->foreign('link_assignee_id')->references('id')->on('ticket_assignees');

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
