<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateEventsTable extends Migration
{
    private const TABLE = 'events';

    public function up(): void
    {
        if (Schema::hasTable(self::TABLE) === true) {
            return;
        }

        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->string('service_type');
            $table->string('shoot_title');
            $table->json('job_description')->nullable();
            $table->date('shoot_date')->nullable();
            $table->string('event_name');
            $table->string('booking_type');
            $table->string('location')->nullable();
            $table->string('contact_name')->nullable();
            $table->time('start_time')->nullable();
            $table->unsignedBigInteger('department_manager')->nullable();
            $table->json('shoot_type');
            $table->string('number_of_dishes')->nullable();
            $table->string('backdrops')->nullable();
            $table->smallInteger('styling_required')->nullable();
            $table->json('outputs');
            $table->date('preferred_due_date')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index('client_id');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->index('created_by');
            $table->foreign('created_by')->references('id')->on('users');
            $table->index('updated_by');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->index('department_manager');
            $table->foreign('department_manager')->references('id')->on('admin_users');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE);

    }
}
