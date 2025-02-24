<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 0; $i < 5; $i++) {
        Client::create([
            'nom' => $faker->name,
            'prenom' => $faker->name,
            //'postnom' => $faker->name,
            'email' => $faker->email,
            'phone' => "998115482$i",
            'password' => bcrypt("123456")
        ]);
    }
    }
}
