<?php

namespace App\Http\Controllers;

use App\Models\Area;

class AreaController extends Controller
{
    public function info(Area $area)
    {
        $byStatus = $area->reports()->active()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return response()->json([
            'area'           => $area->name,
            'active_reports' => $byStatus->sum(),
            'by_status'      => $byStatus,
        ]);
    }
}