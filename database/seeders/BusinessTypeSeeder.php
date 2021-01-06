<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class BusinessTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $data = ['Individual', 'Legal Entity', 'Government'];
        for($i=0;$i < 3; $i++){
            DB::table('business_type')->insert([
                'business_name' => $data[$i],
            ]);
        }
    }
}
