<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lola = User::create([
            'name' => 'Lola Ang',
            'email' => 'lola.ang@bulletin.test',
            'password' => Hash::make('bulletin2026'),
        ]);

        $kagawad = User::create([
            'name' => 'Megan Ang',
            'email' => 'kagawad.ang@bulletin.test',
            'password' => Hash::make('bulletin2026'),
        ]);

        Author::where('email', 'kagawad.ang@bulletin.test')
            ->firstOrFail()
            ->update(['user_id' => $kagawad->id]);

        User::factory()->count(3)->create();
    }
}
