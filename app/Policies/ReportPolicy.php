<?php

namespace App\Policies;

use App\Models\Report;
use App\Models\User;

class ReportPolicy
{
    // Relawan & koordinator boleh lihat semua; pelapor hanya miliknya.
    public function view(User $user, Report $report): bool
    {
        return $user->isRelawan() || $user->isKoordinator() || $report->user_id === $user->id;
    }

    // Hanya pemilik (pelapor) yang boleh mengubah.
    public function update(User $user, Report $report): bool
    {
        return $user->isPelapor() && $report->user_id === $user->id;
    }

    public function review(User $user, Report $report): bool
    {
        return $user->isRelawan();
    }

    public function forward(User $user, Report $report): bool
    {
        return $user->isKoordinator();
    }
}