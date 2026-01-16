<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Service;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var \App\Models\Service $service */
        $service = $this->route('service');

        return $service->status === 'approved'
            && $this->user()->can('create', [Order::class, $service]);
    }

    public function rules(): array
    {
        return [
            // No rules needed as the service comes from the route
        ];
    }
}
