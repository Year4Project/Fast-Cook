<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FoodStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'restaurant_id' => ['required|numeric'],
            'name' => ['required'],
            'code' => ['required|numeric'],
            'oPrice' => ['required|numeric'],
            'dProce' => ['required|numeric'],
            'image' => ['required|image'],
            'stock' => ['required'],
        ];
    }
}
