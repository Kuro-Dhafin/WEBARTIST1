<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Service;

class UpdateServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        $service = $this->route('service');
        return $this->user()->can('update', $service);
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string'],
            'price' => ['sometimes', 'numeric', 'min:0'],
            'pricing_type' => ['sometimes', 'in:per_panel,per_second'],
            'thumbnail' => ['nullable', 'image', 'max:2048'],
        ];
    }
}
