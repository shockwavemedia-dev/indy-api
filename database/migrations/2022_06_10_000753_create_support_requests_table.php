<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateSupportRequestsTable extends Migration
{
    /**
     * @var string
     */
    private const TABLE = 'support_requests';

    public function up(): void
    {
        if (Schema::hasTable(self::TABLE) === true) {
            return;
        }

        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('client_id');
            $table->string('message');
            $table->string('status');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('department_id');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->index('client_id');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->index('created_by');
            $table->foreign('created_by')->references('id')->on('users');
            $table->index('assigned_to');
            $table->foreign('assigned_to')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE);
    }
}
