<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    protected $faker;
    public function __construct(){
       $this->faker = Faker::create();
    }
    public function run(): void
    {
        for($i=0;$i<50;$i++){
            DB::table('orders_tbl')->insert([
                'status' => 1,
                'order_code' => $this->faker->numberBetween(10000000, 99999999),
                'user_id' => rand(1,10)
            ]);
        }
    }
}
