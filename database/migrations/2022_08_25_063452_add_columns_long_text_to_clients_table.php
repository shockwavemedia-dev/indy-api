<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->longText('style_guide')->nullable();
            $table->longText('note')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            if (Schema::hasColumn('clients','style_guide') === true) {
                $table->dropColumn('style_guide');
            }
            if (Schema::hasColumn('clients','notes') === true) {
                $table->dropColumn('notes');
            }
        });
    }
};
