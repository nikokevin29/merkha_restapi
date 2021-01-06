<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
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
            DB::table('product')->insert([
                'id_merchant' => $faker->randomDigitNot(0),
                'id_category' => $faker->randomDigitNot(0),
                'product_name' => $faker->word,
                'description' => $faker->sentence,
                'price' => $faker->numberBetween(1000, 100000),
                'color' => 'Black',
                'size' => 'XL',
                'stock' => $faker->randomDigitNotNull(),
                'weight' => $faker->numberBetween(245,1500),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
    }
}
