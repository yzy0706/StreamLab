
<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class FollowersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Initialize Faker instance
        $faker = Faker::create();

        // Seed 500 rows of data into the followers table
        foreach (range(1, 500) as $index) {
            DB::table('followers')->insert([
                'name' => $faker->userName,
                'is_read' => $faker->boolean,
                'created_at' => $faker->dateTimeBetween('-3 months', 'now'),
                'updated_at' => $faker->dateTimeBetween('-3 months', 'now'),
            ]);
        }
    }
}
    