<?php

use App\Enum\TicketTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('tickets')
            ->where('type', TicketTypeEnum::EVENT)
            ->update([
                'type' => TicketTypeEnum::PROJECT,
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('tickets')
            ->where('type', TicketTypeEnum::PROJECT)
            ->update([
                'type' => TicketTypeEnum::EVENT,
            ]);
    }
};
