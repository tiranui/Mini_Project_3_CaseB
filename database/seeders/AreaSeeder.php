<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (['Kab. Bandung', 'Kab. Garut', 'Kab. Sumedang', 'Kab. Ciamis', 'Kab. Cianjur'] as $name) {
            Area::firstOrCreate(['name' => $name]);
        }
    }
}
