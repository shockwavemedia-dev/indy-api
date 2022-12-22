<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateServicesTable extends Migration
{
    public const TABLE = 'services';

    public function up()
    {
        if (Schema::hasTable(self::TABLE) === true) {
            return;
        }

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('extras')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE);
    }
}
