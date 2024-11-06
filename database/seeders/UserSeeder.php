<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    protected $faker;

    public function __construct() {
        $this->faker = Faker::create();
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 50; $i++) {
            DB::table('users_tbl')->insert([
                'first_name' => $this->faker->firstName,
                'last_name' => $this->faker->lastName,
                'phone_number' => $this->faker->phoneNumber,
                'email' => $this->faker->email,
                'national_code' => $this->faker->numberBetween(10000000, 99999999),
                'gender' => $this->faker->boolean,
                'birthday_date' => $this->faker->date()
            ]);
        }
    }
}
