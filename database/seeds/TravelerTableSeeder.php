<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Traveler;

class TravelerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        Traveler::truncate();

        foreach(range(1, 100) as $i) {
	        Traveler::create([
                'name'              => $faker->firstname,
                'checkin_date'      => $faker->date,
                'ip'                => $faker->ipv4,
                'favorite_country'  => $faker->country,
                'is_active'         => rand(0,1),
                'rating'            => rand(1,999),
            ]);
        }
    }
}
