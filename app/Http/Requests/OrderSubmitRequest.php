<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderSubmitRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // 'name' => 'required|string|max:255', 
            // 'phone' => 'required|string|max:20',
            'total' => 'required|numeric|min:0',
            'payment_amount' => 'required|numeric|min:0',
            'currency' => 'required|string|in:KHR,USD',
            'payment_method' => 'required|array',
            'payment_method.*' => 'required|string|in:credit_card,debit_card,cash',
        ];
    }
}
