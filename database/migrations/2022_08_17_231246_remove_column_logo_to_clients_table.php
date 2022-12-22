<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('clients', 'logo') === true) {
            Schema::table('clients', function (Blueprint $table) {
                $table->dropColumn('logo');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('clients', 'logo') === false) {
            Schema::table('clients', function (Blueprint $table) {
                $table->json('logo')->nullable();
            });
        }
    }
};
