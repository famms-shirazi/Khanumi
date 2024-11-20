<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    protected $englishFaker;
    protected $persianFaker;
    public function __construct(){
        $this->englishFaker = Faker::create();
        $this->persianFaker = Faker::create('fa-IR');
    }
    /**
     * Run the database seeds.
     */
    function generateRandomDouble($min = 0, $max = 100, $precision = 2) {
        $randomFloat = mt_rand($min * pow(10, $precision), $max * pow(10, $precision)) / pow(10, $precision);
        return $randomFloat;
    }

    public function run(): void
    {
        for($i=0; $i < 50 ; $i++){

                DB::table('products_tbl')->insert(
                    [
                        'persian_title'=>$this->persianFaker->word(),
                        'english_title'=>$this->englishFaker->word(),
                        'slug'=>$this->persianFaker->slug(),
                        'product_size'=>$this->generateRandomDouble(10,90),
                        'price'=>$this->generateRandomDouble(10,90),
                        'product_introduction_text'=>$this->persianFaker->text(),
                        'consumption_guide_text'=>$this->persianFaker->text(),
                        'inventory'=>rand(0,1),
                        'special_offer'=>rand(0,1),
                        'brand_id'=>1
                    ]
                );

        }
    }
}
