<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class CampaignSeeder extends Seeder
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
            DB::table('campaign')->insert([
                'id_employee' => $faker->randomDigitNot(0),
                'campaign_code_name' => 'CMP'.$faker->ean8(),
                'campaign_amount' => $faker->randomNumber(4, true),
                'campaign_rate' => 0.2,
                'campaign_type' => $faker->randomElement(['Amount', 'Rate']),
                'max_usage_per_user' => $faker->randomNumber(3, false),
                'min_basket_size' => $faker->randomDigitNotNull(),
                'max_redemption' => $faker->randomDigitNot(0),
                'promo_fund_split' => 0.4,
                'campaign_status' => $faker->randomElement(['Active', 'Inactive']),
                'start_date' => $faker->date(),
                'end_date' => $faker->date(),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
    }
}
