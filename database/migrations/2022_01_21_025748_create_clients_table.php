<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateClientsTable extends Migration
{
    public const TABLE = 'clients';

    public function up(): void
    {
        if (Schema::hasTable(self::TABLE) === true) {
            return;
        }

        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('client_code')->unique();
            $table->longText('logo')->nullable()->default(null);
            $table->string('address')->nullable()->default(null);
            $table->string('phone')->nullable()->default(null);
            $table->string('timezone')->nullable()->default(null);
            $table->dateTime('client_since')->nullable()->default(null);
            $table->unsignedInteger('main_client_id')->nullable()->default(null);
            $table->longText('overview');
            $table->integer('rating')->unsigned();
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE);
    }
}
