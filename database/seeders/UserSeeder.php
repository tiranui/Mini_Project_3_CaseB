<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
    {
        $users = [
            ['Pak Andi (Pelapor)',   'pelapor@example.com',     'pelapor'],
            ['Bu Dewi (Pelapor 2)',  'pelapor2@example.com',    'pelapor'],
            ['Bu Sari (Relawan)',    'relawan@example.com',     'relawan'],
            ['Budi (Koordinator)',   'koordinator@example.com', 'koordinator'],
        ];

        foreach ($users as [$name, $email, $role]) {
            $user = User::firstOrNew(['email' => $email]);
            $user->name = $name;
            $user->password = Hash::make('password');
            $user->role = $role;
            $user->email_verified_at = now();
            $user->save();
        }
    }
}
