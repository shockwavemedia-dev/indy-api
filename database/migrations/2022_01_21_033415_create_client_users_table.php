<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateClientUsersTable extends Migration
{
    public const TABLE = 'client_users';

    public function up(): void
    {
        if (Schema::hasTable(self::TABLE) === true) {
            return;
        }
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->string('client_role');
            $table->timestamps();

            $table->index('client_id');
            $table->foreign('client_id')->references('id')->on('clients');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE);
    }
}
