<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\User\App\Models\User;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->createOrFirst([
            'name' => 'user'], [
            'email' => 'user@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);
    }
}
