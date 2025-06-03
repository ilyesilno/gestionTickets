<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Sla;
use App\Models\abonnement;
use App\Models\Produit;
use App\Models\User;
use App\Models\Agent;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Role::factory()->create([
            'nom' => 'admin'
        ]);


        Role::factory()->create([
            'nom' => 'agent'
        ]);

        Role::factory()->create([
            'nom' => 'client'
        ]);

        

        

        // Users List;


        User::factory()->create([
            'nom_complet' => 'admin',
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password123'),
            'role_id'=> 1
        ]);


        User::factory()->create([
            'nom_complet' => 'client 1',
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password123'),
            'role_id'=> 3
        ]);


//Users of type agents
        User::factory()->create([
            'nom_complet' => 'agent n1',
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password123'),
            'role_id'=> 2
        ]);

        Agent::factory()->create([
            'user_id' => 3,
            'support_level'=> 1
        ]);

        User::factory()->create([
            'nom_complet' => 'agent n2',
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password123'),
            'role_id'=> 2
        ]);

        Agent::factory()->create([
            'user_id' => 4,
            'support_level'=> 2
        ]);

        User::factory()->create([
            'nom_complet' => 'agent n3',
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password123'),
            'role_id'=> 2
        ]);

        Agent::factory()->create([
            'user_id' => 5,
            'support_level'=> 3
        ]);

        Sla::factory()->create([
            'nom' => 'Standard',
            'duree_qualification' => 5,
            'duree_resolution' => 7
        ]);

        Sla::factory()->create([
            'nom' => 'Premium',
            'duree_qualification' => 2,
            'duree_resolution' => 3
        ]);

        Produit::factory()->create([
            'nom' => 'app 1',
            'user_id' => 2
        ]);

        abonnement::factory()->create([
            'date_debut' => '2025-06-15',
            'date_fin' => '2026-06-15',
            'produitID' => 1,
            'slaID' => 1 

        ]);

        

       

        
        

        


    }
}
