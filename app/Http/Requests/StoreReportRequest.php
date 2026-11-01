<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isPelapor() ?? false;
    }

    public function rules(): array
    {
        return [
            'area_id'     => ['required', 'exists:areas,id'],
            'title'       => ['required', 'string', 'max:150'],
            'description' => ['required', 'string', 'max:2000'],
            'latitude'    => ['required', 'numeric', 'between:-90,90'],
            'longitude'   => ['required', 'numeric', 'between:-180,180'],
            'occurred_at' => ['required', 'date', 'before_or_equal:now'],
        ];
    }
}