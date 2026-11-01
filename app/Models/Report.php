<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public const MENUNGGU_REVIEW = 'menunggu_review';
    public const SEDANG_DITINJAU = 'sedang_ditinjau';
    public const PERLU_TINDAKAN = 'perlu_tindakan';
    public const SELESAI = 'selesai';

    public const STATUSES = [
        self::MENUNGGU_REVIEW, self::SEDANG_DITINJAU, self::PERLU_TINDAKAN, self::SELESAI,
    ];

    public function scopeActive($query)
    {
        return $query->where('status', '!=', self::SELESAI);
    }

    public const TRANSITIONS = [
    self::MENUNGGU_REVIEW => [self::SEDANG_DITINJAU],
    self::SEDANG_DITINJAU => [self::PERLU_TINDAKAN],
    self::PERLU_TINDAKAN  => [self::SELESAI],
    self::SELESAI         => [],
    ];

    public const REVIEWER_STATUSES = [self::SEDANG_DITINJAU, self::PERLU_TINDAKAN];

    // BR-01: laporan hanya bisa diedit pelapor saat menunggu_review
    public function isEditable(): bool
    {
        return $this->status === self::MENUNGGU_REVIEW;
    }

    public function canTransitionTo(string $newStatus): bool
    {
        return in_array($newStatus, self::TRANSITIONS[$this->status] ?? [], true);
    }

    // BR-02: penerusan info hanya saat perlu_tindakan
    public function canBeForwarded(): bool
    {
        return $this->status === self::PERLU_TINDAKAN;
    }

    protected $fillable = [
        'user_id', 'area_id', 'title', 'description',
        'latitude', 'longitude', 'occurred_at',
        'status', 'evidence_path', 'reviewer_note',
        'forwarded_to', 'forwarded_at',
    ];

    protected $casts = [
        'occurred_at'  => 'datetime',
        'forwarded_at' => 'datetime',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function area() { return $this->belongsTo(Area::class); }
    public function logs() { return $this->hasMany(ReportLog::class); }
}
