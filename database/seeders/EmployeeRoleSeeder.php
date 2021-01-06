<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class EmployeeRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $data = ['Super Admin', 'Admin', 'Staff'];
        for($i=0;$i < 3; $i++){
            DB::table('employee_role')->insert([
                'name' => $data[$i],
                'description' => $faker->realText($maxNbChars = 200, $indexSize = 2),
            ]);
        }
    }
}
