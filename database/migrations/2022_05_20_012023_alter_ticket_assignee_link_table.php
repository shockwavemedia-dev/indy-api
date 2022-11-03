<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTicketAssigneeLinkTable extends Migration
{
    /**
     * @var string
     */
    private const TABLE = 'ticket_assignee_links';

    public function up(): void
    {
        if (env('DB_CONNECTION') === 'sqlite') {
            return;
        }

        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->unsignedBigInteger('updated_by')
                ->nullable()
                ->change();
        });
    }

    public function down(): void
    {
    }
}
