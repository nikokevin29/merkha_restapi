<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class MerchantBankSeeder extends Seeder
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
            DB::table('merchant_bank')->insert([
                'id_merchant' => $faker->randomDigitNot(0),
                'bank_name' => $faker->randomElement(['BRI', 'BNI', 'Mandiri', 'BCA', 'CIMB Niaga']),
                'bank_account_number' => $faker->ean13(),
                'holders_name' => $faker->firstName .' '. $faker->lastName,
                'letter_of_authorization' => 'authorization-letters.pdf',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
    }
}
