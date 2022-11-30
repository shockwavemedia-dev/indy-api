<?php

use App\Models\TicketFileVersion;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ticket_notes', function (Blueprint $table) {
            $table->foreignIdFor(TicketFileVersion::class, 'ticket_file_version_id')->nullable();

            $table->foreign('ticket_file_version_id')->references('id')->on('ticket_file_versions');
        });
    }

    public function down(): void
    {
        Schema::table('ticket_notes', function (Blueprint $table) {
            $table->dropForeign('ticket_notes_ticket_file_version_id_foreign');
            $table->dropColumn('ticket_file_version_id');
        });
    }
};
