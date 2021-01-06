<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class MerchantSeeder extends Seeder
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
            DB::table('merchant')->insert([
                'id_user' => $faker->randomDigitNot(0),
                'id_business_type' => $faker->randomElement([1,2,3]),
                'id_merchant_category' => $faker->randomElement([1,2,3,4,5,6,7]),
                'merchant_id' => 'MIDMTI'.$faker->ean8(),
                'name' => $faker->company,
                'merchant_logo' => $faker->imageUrl(640, 480, 'animals', true),
                'description' => $faker->sentence,
                'website' => $faker->domainName,
                'email' => $faker->companyEmail,
                'phone_number' => $faker->phoneNumber,

                'street' => $faker->streetName,
                'district' => $faker->state,
                'postcode' => $faker->postcode,
                'city' => $faker->city,
                'country' => $faker->country,
                'unit' => $faker->randomDigitNot(0),
                'timezone' => $faker->timezone,
                'longlat' => $faker->longitude($min = -180, $max = 180).', '.$faker->latitude($min = -90, $max = 90),

                'mall' => $faker->randomElement(['Hartono', 'Ambarrukmo', 'Jogja City', 'Sleman City']),
                'building_name' => $faker->buildingNumber,
                'floor' => $faker->randomDigitNot(0),
                'other_notes' => 'Nothing',
                
                'status' => $faker->randomElement(['Active', 'Waiting for Approval', 'Paused', 'Idle', 'Inactive', 'Reported']),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
    }
}
