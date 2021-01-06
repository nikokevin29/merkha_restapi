<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class AddressSeeder extends Seeder
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
            DB::table('address')->insert([
                'id_user' => $faker->randomDigitNot(0),
                'address_save_name' => $faker->randomElement(['Rumah', 'Kantor']),
                'address' => $faker->streetAddress,
                'postal_code' => $faker->postcode,
                'city' => $faker->city,
                'province' => $faker->state,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
    }
}
