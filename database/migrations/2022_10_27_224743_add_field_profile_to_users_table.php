<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\File;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignIdFor(File::class, 'profile_file_id')->nullable();
            $table->smallInteger('display_in_dashboard')->default(false);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeignIdFor('profile_file_id');
            $table->dropColumn('display_in_dashboard');
        });
    }
};
