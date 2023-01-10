<?php

use App\Models\Tickets\Ticket;
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
        Schema::create('style_guide_comments', function (Blueprint $table) {
            $table->id();
            $table->json('message');
            $table->foreignIdFor(Ticket::class, 'ticket_id');
            $table->foreign('ticket_id')->references('id')->on('tickets');
            $table->foreignIdFor(User::class, 'user_id');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('style_guide_comments');
    }
};
