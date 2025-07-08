<?php

namespace Database\Seeders;

use App\Models\Plat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class PlatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Faker::create();
        $matricules = "089356";
        for ($i = 0; $i < 20; $i++) {
            $code = rand(100000, 999999);
            Plat::create([
                'nom' => $faker->name,
                'photo' => "https://jenos-food.s3.amazonaws.com/plats/686d140a7d3da_banane.jpg",
                'prix' => $i + $code,
                'details' => 'les details de la commandes',
                'status' => true
            ]);
        }
    }
}
