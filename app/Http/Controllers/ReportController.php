<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Models\Area;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ReportController extends Controller
{
public function index(Request $request)
{
    $filters = $request->validate([
        'q'       => ['nullable', 'string', 'max:100'],
        'area_id' => ['nullable', 'integer', 'exists:areas,id'],
        'status'  => ['nullable', Rule::in(Report::STATUSES)],
    ]);

    $user = $request->user();

    $reports = Report::with(['area', 'user'])
        ->when($user->isPelapor(), fn ($q) => $q->where('user_id', $user->id))
        ->when($filters['q'] ?? null, fn ($q, $v) => $q->where('title', 'like', '%' . $v . '%'))
        ->when($filters['area_id'] ?? null, fn ($q, $v) => $q->where('area_id', $v))
        ->when($filters['status'] ?? null, fn ($q, $v) => $q->where('status', $v))
        ->latest()
        ->paginate(10)
        ->withQueryString();

    return view('reports.index', [
        'reports' => $reports,
        'areas'   => Area::orderBy('name')->get(),
    ]);
}

    public function create()
    {
        return view('reports.create', ['areas' => Area::orderBy('name')->get()]);
    }

    public function edit(Report $report)
{
    Gate::authorize('update', $report);
    abort_unless($report->isEditable(), 403, 'BR-01: laporan tidak dapat diedit karena sudah diproses.');

    return view('reports.edit', [
        'report' => $report,
        'areas'  => Area::orderBy('name')->get(),
    ]);
}

public function update(UpdateReportRequest $request, Report $report)
{
    Gate::authorize('update', $report);
    abort_unless($report->isEditable(), 403, 'BR-01: laporan tidak dapat diedit karena sudah diproses.');

    $data = Arr::except($request->validated(), 'evidence');

    if ($request->hasFile('evidence')) {
        if ($report->evidence_path) {
            Storage::delete($report->evidence_path);
        }
        $data['evidence_path'] = $request->file('evidence')->store('evidence');
    }

    $report->update($data);

    return redirect()->route('reports.show', $report)->with('success', 'Laporan diperbarui.');
}

// Relawan Pemantau
public function review(Request $request, Report $report)
{
    Gate::authorize('review', $report);

    $data = $request->validate([
        // BR-03: relawan hanya boleh memilih sedang_ditinjau / perlu_tindakan
        'status'        => ['required', Rule::in(Report::REVIEWER_STATUSES)],
        'reviewer_note' => ['nullable', 'string', 'max:1000'],
    ]);

    if (! $report->canTransitionTo($data['status'])) {
        return back()->withErrors([
            'status' => "Perubahan status dari {$report->status} ke {$data['status']} tidak sesuai alur.",
        ]);
    }

    $report->update($data);

    return back()->with('success', 'Status laporan diperbarui.');
}

// Koordinator Relawan
public function forward(Request $request, Report $report)
{
    Gate::authorize('forward', $report);

    if (! $report->canBeForwarded()) {
        return back()->withErrors([
            'forwarded_to' => 'BR-02: informasi hanya dapat diteruskan jika status perlu_tindakan.',
        ]);
    }

    $data = $request->validate(['forwarded_to' => ['required', 'string', 'max:150']]);

    $report->update([
        'forwarded_to' => $data['forwarded_to'],
        'forwarded_at' => now(),
        'status'       => Report::SELESAI,
    ]);

    return back()->with('success', 'Penerusan informasi tercatat.');
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
        $report->load(['area', 'user', 'logs.user']);

        return view('reports.show', compact('report'));
    }

    public function evidence(Report $report)
    {
        Gate::authorize('view', $report);
        abort_unless($report->evidence_path && Storage::exists($report->evidence_path), 404);

        return Storage::response($report->evidence_path);
    }
}