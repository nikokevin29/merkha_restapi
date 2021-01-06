<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class MerchantCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = ['Man Fashion', 'Woman Fashion', 'Man Accesories', 'Woman Accesories', 'Music', 'Merchandise', 'Shoes'];
        for($i=0;$i < 7; $i++){
            DB::table('merchant_category')->insert([
                'category_name' => $data[$i],
            ]);
        }
    }
}
