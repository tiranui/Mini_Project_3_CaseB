<?php

namespace App\Observers;

use App\Models\Report;
use App\Models\ReportLog;
use Illuminate\Support\Facades\Auth;

class ReportObserver
{
    public function created(Report $report): void
    {
        $this->log($report, null, $report->status);
    }

    public function updated(Report $report): void
    {
        if ($report->wasChanged('status')) {
            $this->log($report, $report->getOriginal('status'), $report->status);
        }
    }

    private function log(Report $report, ?string $old, string $new): void
    {
        ReportLog::create([
            'report_id'  => $report->id,
            'user_id'    => Auth::id(),
            'old_status' => $old,
            'new_status' => $new,
        ]);
    }
}