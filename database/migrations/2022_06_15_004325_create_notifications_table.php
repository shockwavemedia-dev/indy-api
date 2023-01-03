<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateNotificationsTable extends Migration
{
    public const TABLE = 'notifications';

    public function up(): void
    {
        if (Schema::hasTable(self::TABLE) === false) {
            Schema::create(self::TABLE, function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('description')->nullable();
                $table->string('link')->nullable();
                $table->string('status');
                $table->morphs('morphable');
                $table->timestamps();
                $table->softDeletes();

                $table->index(['morphable_id', 'morphable_type']);
            });
        }

        if (Schema::hasTable('notification_users') === false) {
            Schema::create('notification_users', function (Blueprint $table) {
                $table->id();
                $table->string('title')->nullable();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('notification_id');
                $table->index(['user_id', 'notification_id']);
                $table->foreign('user_id')->references('id')->on('users');
                $table->foreign('notification_id')->references('id')->on(self::TABLE);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_users');
        Schema::dropIfExists(self::TABLE);
    }
}
