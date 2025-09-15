<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin\Role;
use App\Enums\UserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'user_name' => 'admin',
            'name' => 'System Administrator',
            'phone' => '1234567890',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'profile' => 'System administrator with full access to all features',
            'balance' => 0,
            'max_score' => 0.00,
            'status' => 1,
            'is_changed_password' => 1,
            'agent_id' => null,
            'type' => UserType::Admin->value,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create Player Users
        $players = [
            [
                'user_name' => 'player1',
                'name' => 'John Player',
                'phone' => '1234567891',
                'email' => 'player1@example.com',
                'password' => Hash::make('password'),
                'profile' => 'Regular player account',
                'balance' => 1000,
                'max_score' => 1500.50,
                'status' => 1,
                'is_changed_password' => 1,
                'agent_id' => $admin->id,
                'type' => UserType::Player->value,
            ],
            [
                'user_name' => 'player2',
                'name' => 'Jane Player',
                'phone' => '1234567892',
                'email' => 'player2@example.com',
                'password' => Hash::make('password'),
                'profile' => 'Regular player account',
                'balance' => 500,
                'max_score' => 800.25,
                'status' => 1,
                'is_changed_password' => 1,
                'agent_id' => $admin->id,
                'type' => UserType::Player->value,
            ],
            [
                'user_name' => 'player3',
                'name' => 'Bob Player',
                'phone' => '1234567893',
                'email' => 'player3@example.com',
                'password' => Hash::make('password'),
                'profile' => 'Regular player account',
                'balance' => 2000,
                'max_score' => 2200.75,
                'status' => 1,
                'is_changed_password' => 1,
                'agent_id' => $admin->id,
                'type' => UserType::Player->value,
            ],
        ];

        foreach ($players as $playerData) {
            User::create($playerData);
        }

        // Assign roles to users
        $adminRole = Role::where('title', 'Admin')->first();
        $playerRole = Role::where('title', 'Player')->first();

        if ($adminRole && $playerRole) {
            // Assign admin role to admin user
            $admin->roles()->attach($adminRole->id);

            // Assign player role to all player users
            $playerUsers = User::where('type', UserType::Player->value)->get();
            foreach ($playerUsers as $player) {
                $player->roles()->attach($playerRole->id);
            }
        }

        // Create additional test players
        $additionalPlayers = [
            [
                'user_name' => 'test_player1',
                'name' => 'Test Player One',
                'phone' => '1234567894',
                'email' => 'test1@example.com',
                'password' => Hash::make('password'),
                'profile' => 'Test player account',
                'balance' => 750,
                'max_score' => 1200.00,
                'status' => 1,
                'is_changed_password' => 0,
                'agent_id' => $admin->id,
                'type' => UserType::Player->value,
            ],
            [
                'user_name' => 'test_player2',
                'name' => 'Test Player Two',
                'phone' => '1234567895',
                'email' => 'test2@example.com',
                'password' => Hash::make('password'),
                'profile' => 'Test player account',
                'balance' => 300,
                'max_score' => 600.50,
                'status' => 1,
                'is_changed_password' => 0,
                'agent_id' => $admin->id,
                'type' => UserType::Player->value,
            ],
        ];

        foreach ($additionalPlayers as $playerData) {
            $player = User::create($playerData);
            if ($playerRole) {
                $player->roles()->attach($playerRole->id);
            }
        }

        // Create a super admin with different agent
        $superAdmin = User::create([
            'user_name' => 'superadmin',
            'name' => 'Super Administrator',
            'phone' => '1234567896',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
            'profile' => 'Super administrator with elevated privileges',
            'balance' => 0,
            'max_score' => 0.00,
            'status' => 1,
            'is_changed_password' => 1,
            'agent_id' => null,
            'type' => UserType::Admin->value,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($adminRole) {
            $superAdmin->roles()->attach($adminRole->id);
        }
    }
}
