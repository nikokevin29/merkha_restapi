<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class VoucherSeeder extends Seeder
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
            DB::table('voucher')->insert([
                'id_merchant' => $faker->randomDigitNot(0),
                'id_employee' => $faker->randomDigitNot(0),
                'voucher_name' => $faker->word,
                'voucher_code' => $faker->ean8(),
                'voucher_type' => $faker->randomElement(['Amount', 'Rate']),
                'disc_amount' => $faker->numberBetween(1000, 10000),
                'disc_rate' => 10.00,
                'valid_date' => $faker->date(),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
    }
}
