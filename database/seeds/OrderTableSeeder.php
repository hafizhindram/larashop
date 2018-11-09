<?php

use Illuminate\Database\Seeder;
use App\Order;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $order = new Order;
        $order->user_id = '1';
        $order->total_price = '150000';
        $order->invoice_number = '201811060001';
        $order->status = 'FINISH';

        $order->save();

        $this->command->info("User admin berhasil ditambahkan");
    }
}
