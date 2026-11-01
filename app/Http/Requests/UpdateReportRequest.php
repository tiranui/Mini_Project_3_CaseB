<?php

namespace App\Http\Requests;

class UpdateReportRequest extends StoreReportRequest
{
    public function authorize(): bool
    {
        return true; // otorisasi (ownership) dicek di controller lewat Gate
    }
}