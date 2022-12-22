<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PrinterJobsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('printer_jobs')->delete();

        \DB::table('printer_jobs')->insert([
            0 => [
                'additional_options' => null,
                'address' => 'to Venue',
                'blind_shipping' => 0,
                'client_id' => 1,
                'coding' => 'Medium gsm paper',
                'created_at' => '2022-12-20 04:33:09',
                'created_by' => 7,
                'customer_name' => null,
                'deleted_at' => null,
                'delivery' => 'To Venue',
                'description' => 'Mothers Day Cards',
                'final_trim_size' => null,
                'format' => 'Landscape',
                'id' => 1,
                'is_approved' => null,
                'kinds' => null,
                'notes' => null,
                'option' => 'Two sided',
                'price' => null,
                'printer_id' => 1,
                'product' => 'Postcards',
                'purchase_order_number' => null,
                'quantity' => '1500',
                'reference' => null,
                'reseller_samples' => 0,
                'run_ons' => null,
                'status' => 'Awaiting Quote',
                'stocks' => 'Gloss',
                'updated_at' => '2022-12-20 04:33:09',
                'updated_by' => null,
            ],
        ]);
    }
}
