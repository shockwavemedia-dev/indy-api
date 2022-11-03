<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateEmailLogsTable extends Migration
{
    /**
     * @var string
     */
    private const TABLE = 'email_logs';

    public function up(): void
    {
        if (Schema::hasTable(self::TABLE) === true) {
            return;
        }

        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->morphs('morphable');
            $table->string('status');
            $table->string('failed_details')->nullable();
            $table->string('to');
            $table->string('cc')->nullable();
            $table->string('message');
            $table->softDeletes();
            $table->timestamps();

            $table->index(['morphable_id', 'morphable_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE);
    }
}
