<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class PromotionSeeder extends Seeder
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
            DB::table('promotion')->insert([
                'id_merchant' => $faker->randomDigitNot(0),
                'id_product' => $faker->randomDigitNot(0),
                'promo_content' => $faker->word(),
                'promo_amount' => $faker->randomNumber(5, true),
                'active_status' => 1,
                'photo' => $faker->imageUrl(640, 480, 'animals', true),
                'start_time' => $faker->datetime(),
                'end_time' =>  $faker->datetime(),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
    }
}
