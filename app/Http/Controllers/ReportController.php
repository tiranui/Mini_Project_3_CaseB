<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReportRequest;
use App\Models\Area;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

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
        $data = Arr::except($request->validated(), 'evidence');
        $data['status'] = Report::MENUNGGU_REVIEW;

        if ($request->hasFile('evidence')) {
            $data['evidence_path'] = $request->file('evidence')->store('evidence'); // disk privat (local)
        }

        $request->user()->reports()->create($data);

        return redirect()->route('reports.index')->with('success', 'Laporan berhasil dikirim.');
    }
        public function show(Report $report)
    {
        Gate::authorize('view', $report);
        $report->load(['area', 'user']);

        return view('reports.show', compact('report'));
    }

    public function evidence(Report $report)
    {
        Gate::authorize('view', $report);
        abort_unless($report->evidence_path && Storage::exists($report->evidence_path), 404);

        return Storage::response($report->evidence_path);
    }
}