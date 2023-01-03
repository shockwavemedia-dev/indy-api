<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateSupportRequestChatsTable extends Migration
{
    /**
     * @var string
     */
    private const TABLE = 'support_request_chats';

    public function up(): void
    {
        if (Schema::hasTable(self::TABLE) === true) {
            return;
        }

        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('support_request_id');
            $table->unsignedBigInteger('sender_id');
            $table->string('message');
            $table->timestamps();
            $table->softDeletes();

            $table->index('support_request_id');
            $table->foreign('support_request_id')->references('id')->on('support_requests');
            $table->index('sender_id');
            $table->foreign('sender_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE);
    }
}
