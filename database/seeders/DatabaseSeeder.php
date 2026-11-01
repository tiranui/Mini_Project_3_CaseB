<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Area;
use App\Models\Report;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
public function run(): void
{
    $area1 = Area::create(['name' => 'Kawasan Hutan Lindung X', 'latitude' => -0.12345678, 'longitude' => 101.12345678]);
    $area2 = Area::create(['name' => 'Perkebunan Warga Y', 'latitude' => -0.87654321, 'longitude' => 102.87654321]);

    $pelapor = User::create(['name' => 'Pak Andi', 'email' => 'pelapor@test.com', 'password' => bcrypt('password'), 'role' => 'pelapor']);
    $relawan = User::create(['name' => 'Bu Sari', 'email' => 'relawan@test.com', 'password' => bcrypt('password'), 'role' => 'relawan']);
    $koordinator = User::create(['name' => 'Budi', 'email' => 'koordinator@test.com', 'password' => bcrypt('password'), 'role' => 'koordinator']);

    Report::create([
        'user_id' => $pelapor->id, 'area_id' => $area1->id, 'title' => 'Asap Tebal di Area X',
        'description' => 'Terlihat asap tebal dari arah utara.', 'latitude' => -0.12345678, 'longitude' => 101.12345678,
        'status' => 'menunggu_review'
    ]);
    Report::create([
        'user_id' => $pelapor->id, 'area_id' => $area2->id, 'title' => 'Api Kecil di Perkebunan',
        'description' => 'Warga melihat api membakar ilalang.', 'latitude' => -0.87654321, 'longitude' => 102.87654321,
        'status' => 'selesai'
    ]);
}
}
