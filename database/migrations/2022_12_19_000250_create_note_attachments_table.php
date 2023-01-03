<?php

use App\Models\File;
use App\Models\Tickets\TicketNote;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('note_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(File::class, 'file_id');
            $table->foreignIdFor(TicketNote::class, 'ticket_note_id');
            $table->foreignIdFor(User::class, 'created_by');
            $table->foreign('file_id')->references('id')->on('files');
            $table->foreign('ticket_note_id')->references('id')->on('ticket_notes');
            $table->foreign('created_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('note_attachments');
    }
};
