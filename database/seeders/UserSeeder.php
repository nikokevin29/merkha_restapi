<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
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
            DB::table('user')->insert([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->unique()->email,
                'username' => $faker->unique()->username,
                'password' => Hash::make('password'),
                'email_verified_at' => date("Y-m-d H:i:s"),
                'gender' => 'Prefer not to say',
                'phone_number' => $faker->unique()->phoneNumber,
                'url_photo' => $faker->imageUrl(640, 640, 'animals', true),
                'bio' => $faker->word(),
                'followers_count' => $faker->randomNumber(4, true),
                'following_count' => $faker->randomNumber(3, true),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
    }
}
