<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Faker::create();
        $matricules = "089356";
        for ($i = 0; $i < 40; $i++) {
            $matricule = $matricules . $i;
            User::create([
                'nom' => $faker->name,
                'prenom' => $faker->name,
                //'postnom' => $faker->name,
                'email' => $faker->email,
                'phone' => $matricule,
                'password' => bcrypt(12345678)
            ]);
        }
    }
}
