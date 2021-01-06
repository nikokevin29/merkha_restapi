<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class AppContentSeeder extends Seeder
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
            DB::table('app_content')->insert([
                'id_employee' => $faker->randomDigitNot(0),
                'parent' => $faker->randomElement(['Background Banner', 'Hero Banner', 'Collections']),
                'location' => $faker->randomElement(['Main Page', 'Category 1', 'Category 2']),
                'position' => 'position',
                'url_image' => $faker->imageUrl(640, 480, 'animals', true),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
    }
}
