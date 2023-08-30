<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FollowersSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();
        
        foreach (range(1, 300) as $index) {
            DB::table('followers')->insert([
                'name' => $faker->name,
                'is_read' => $faker->boolean,
                'created_at' => Carbon::now()->subDays(rand(0, 90)),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}