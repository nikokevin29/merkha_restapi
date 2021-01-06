<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class OrderDetailSeeder extends Seeder
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
            DB::table('order_detail')->insert([
                'id_order' => $faker->randomDigitNot(0),
                'id_product' => $faker->randomDigitNot(0),
                'amount' =>$faker->randomNumber(3, true),
                'subtotal' => $faker->randomNumber(4, true),
            ]);
        }
    }
}
