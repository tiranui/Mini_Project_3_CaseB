<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Report;
use Illuminate\Http\Request;

class RecapController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate(['area_id' => ['nullable', 'integer', 'exists:areas,id']]);
        $areaId = $filters['area_id'] ?? null;

        $base = Report::query()->when($areaId, fn ($q, $v) => $q->where('area_id', $v));

        $total   = (clone $base)->count();
        $selesai = (clone $base)->where('status', Report::SELESAI)->count();
        $aktif   = $total - $selesai;

        $rows = Area::query()
            ->when($areaId, fn ($q, $v) => $q->where('id', $v))
            ->withCount([
                'reports as total_count',
                'reports as active_count' => fn ($q) => $q->where('status', '!=', Report::SELESAI),
                'reports as done_count'   => fn ($q) => $q->where('status', Report::SELESAI),
            ])
            ->orderBy('name')
            ->get();

        return view('recap', [
            'total'   => $total,
            'aktif'   => $aktif,
            'selesai' => $selesai,
            'rows'    => $rows,
            'areas'   => Area::orderBy('name')->get(),
        ]);
    }
}