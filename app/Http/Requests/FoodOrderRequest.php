<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FoodOrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'items' => 'required|array',
            'items.*.food_id' => 'required|exists:foods,id',
            'items.*.quantity' => 'required|integer|min:1',
            'table_no' => 'required|integer|min:1',
            'restaurant_id' => 'required|integer|min:1',
            'remark' => 'nullable|string',
        ];
    }
}
