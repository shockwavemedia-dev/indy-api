<?php

use App\Models\File;
use App\Models\Tickets\ClientTicketFile;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_file_versions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('version');
            $table->foreignIdFor(ClientTicketFile::class, 'ticket_file_id');
            $table->foreignIdFor(File::class, 'file_id');
            $table->string('status')->nullable();
            $table->timestamps();

            $table->foreign('ticket_file_id')->references('id')->on('client_ticket_files');
            $table->foreign('file_id')->references('id')->on('files');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_file_versions');
    }
};
