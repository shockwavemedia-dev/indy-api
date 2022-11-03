<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateAdminDepartmentsTable extends Migration
{

    public const TABLE = 'admin_departments';

    public function up() : void
    {
        if (Schema::hasTable(self::TABLE) === true) {
            return;
        }

        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('admin_user_id');
            $table->timestamps();

            $table->index('department_id');
            $table->index('admin_user_id');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('admin_user_id')->references('id')->on('admin_users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE);
    }
}
