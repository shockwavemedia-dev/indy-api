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
        
        \DB::table('printer_jobs')->insert(array (
            0 => 
            array (
                'additional_options' => NULL,
                'address' => 'to Venue',
                'blind_shipping' => 0,
                'client_id' => 1,
                'coding' => 'Medium gsm paper',
                'created_at' => '2022-12-20 04:33:09',
                'created_by' => 7,
                'customer_name' => NULL,
                'deleted_at' => NULL,
                'delivery' => 'To Venue',
                'description' => 'Mothers Day Cards',
                'final_trim_size' => NULL,
                'format' => 'Landscape',
                'id' => 1,
                'is_approved' => NULL,
                'kinds' => NULL,
                'notes' => NULL,
                'option' => 'Two sided',
                'price' => NULL,
                'printer_id' => 1,
                'product' => 'Postcards',
                'purchase_order_number' => NULL,
                'quantity' => '1500',
                'reference' => NULL,
                'reseller_samples' => 0,
                'run_ons' => NULL,
                'status' => 'Awaiting Quote',
                'stocks' => 'Gloss',
                'updated_at' => '2022-12-20 04:33:09',
                'updated_by' => NULL,
            ),
        ));
        
        
    }
}