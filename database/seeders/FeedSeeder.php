<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class FeedSeeder extends Seeder
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
            DB::table('feed')->insert([
                'id_user' => $faker->randomDigitNot(0),
                'id_merchant' => $faker->randomDigitNot(0),
                'id_product' => $faker->randomDigitNot(0),
                'like_count' => $faker->randomDigitNot(0),
                'url_image' => $faker->imageUrl(640, 480, 'animals', true),
                'caption' => $faker->sentence(),
                'location' => $faker->city(),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
    }
}
