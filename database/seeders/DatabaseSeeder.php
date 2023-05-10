<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Entity;
use App\Models\Line;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            EntitySeeder::class,
            ClientSeeder::class
        ]);

        // Get all the clients attaching up to 2 random lines
        $lines = Line::all();

        // Populate the pivot table
        Client::all()->each(function ($client) use ($lines) {
            $client->lines()->attach(
                $lines->random(rand(1, 2))->pluck('id')->toArray()
            );
        });

        //Same thing for users and entities, but only for entities workers
        // Get all the users attaching up to 2 random lines
        $users = User::where('role', 'NOT LIKE', 'user')->get();

        // Populate the pivot table
        Entity::all()->each(function ($entity) use ($users) {
            $entity->users()->attach(
                $users->random(rand(1, 2))->pluck('id')->toArray()
            );
        });
    }
}
