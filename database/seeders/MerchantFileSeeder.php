<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class MerchantFileSeeder extends Seeder
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
            DB::table('merchant_file')->insert([
                'id_merchant' => $faker->randomDigitNot(0),
                'ktp' => $faker->ean13(),
                'npwp' => $faker->isbn13(),
                'statement_letter' => 'statement-letter.pdf',
                'storefront_photo' => $faker->imageUrl(640, 480, 'animals', true),
                'business_license' => 'business-license.pdf',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
    }
}
