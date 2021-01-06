<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        for($i=0;$i < 10; $i++){
            DB::table('order')->insert([
                'id_merchant' => $faker->randomDigitNot(0),
                'id_buyer'=> $faker->randomDigitNot(0),
                'id_destination'=> $faker->randomDigitNot(0),
                'id_voucher'=> $faker->randomDigitNot(0),
                'id_campaign'=> $faker->randomDigitNot(0),
                'received_date'=> $faker->date(),
                'order_status'=> 'PENDING',
                'shipping_price'=> $faker->randomNumber(4, true),
                'discount_price'=> $faker->randomNumber(3, true),
                'total_price'=> $faker->randomNumber(4, true),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
    }
}
