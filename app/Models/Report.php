<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public const MENUNGGU_REVIEW = 'menunggu_review';
    public const SEDANG_DITINJAU = 'sedang_ditinjau';
    public const PERLU_TINDAKAN  = 'perlu_tindakan';
    public const SELESAI         = 'selesai';

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
