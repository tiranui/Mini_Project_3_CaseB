<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
    {
        $pelapor1 = User::where('email', 'pelapor@example.com')->first();
        $pelapor2 = User::where('email', 'pelapor2@example.com')->first();
        $areas    = Area::pluck('id', 'name');

        $data = [
            [$pelapor1, 'Kab. Bandung',  'Asap tebal di kebun teh',      'menunggu_review', -7.1500000, 107.5000000],
            [$pelapor1, 'Kab. Garut',    'Api kecil di semak kering',    'sedang_ditinjau', -7.2200000, 107.9000000],
            [$pelapor1, 'Kab. Garut',    'Lahan terbakar dekat jalan',   'perlu_tindakan',  -7.2300000, 107.9100000],
            [$pelapor2, 'Kab. Bandung',  'Kebakaran lahan gambut',       'perlu_tindakan',  -7.1600000, 107.5100000],
            [$pelapor2, 'Kab. Sumedang', 'Asap dari hutan pinus',        'menunggu_review', -6.8500000, 107.9200000],
            [$pelapor2, 'Kab. Ciamis',   'Pembakaran lahan warga',       'selesai',         -7.3300000, 108.3500000],
            [$pelapor1, 'Kab. Cianjur',  'Titik api di lereng bukit',    'selesai',         -6.8200000, 107.1400000],
            [$pelapor1, 'Kab. Bandung',  'Asap di area perkebunan',      'sedang_ditinjau', -7.1400000, 107.4900000],
        ];

        foreach ($data as $i => [$user, $area, $title, $status, $lat, $lng]) {
            Report::create([
                'user_id'      => $user->id,
                'area_id'      => $areas[$area],
                'title'        => $title,
                'description'  => 'Data dummy untuk pengujian: ' . $title . '.',
                'latitude'     => $lat,
                'longitude'    => $lng,
                'occurred_at'  => now()->subDays($i + 1),
                'status'       => $status,
                'forwarded_to' => $status === 'selesai' ? 'BPBD (dummy)' : null,
                'forwarded_at' => $status === 'selesai' ? now()->subDay() : null,
            ]);
        }
    }
}
