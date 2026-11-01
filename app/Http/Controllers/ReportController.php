<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReportRequest;
use App\Models\Area;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $reports = Report::with('area')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        return view('reports.create', ['areas' => Area::orderBy('name')->get()]);
    }

    public function store(StoreReportRequest $request)
    {
        $data = $request->validated();
        $data['status'] = Report::MENUNGGU_REVIEW;

        $request->user()->reports()->create($data);

        return redirect()->route('reports.index')->with('success', 'Laporan berhasil dikirim.');
    }
}