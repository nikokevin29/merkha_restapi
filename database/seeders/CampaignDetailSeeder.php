<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class CampaignDetailSeeder extends Seeder
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
            DB::table('campaign_detail')->insert([
                'id_campaign'=> $faker->randomDigitNot(0),
                'id_merchant' => $faker->randomDigitNot(0),
            ]);
        }
    }
}
