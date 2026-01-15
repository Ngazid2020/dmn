<?php

namespace Database\Seeders;

use App\Models\Etablissement;
use App\Models\Patient;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $etablissement = Etablissement::factory()->create([
            'name' => 'Etablissement 1',
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);
        

        $admin->etablissements()->attach($etablissement);

        User::factory(10)->create();
        User::whereId(2)->first()->etablissements()->attach($etablissement);
        // Patient::factory(30)->create();
    }
    

}
