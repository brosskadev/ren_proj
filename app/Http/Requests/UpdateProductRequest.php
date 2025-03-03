<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'status' => 'required|string',
            'attributes' => 'nullable|array',
            'article' => function ($attribute, $value, $fail) {
                $product = Product::where('article', $this->route('article'))->first();
                
                if (!$product) {
                    $fail('Продукт не найден.');
                    return;
                }

                if (Auth::user()->role !== 'admin' && $value !== $product->article) {
                    $fail('Вы не можете изменять артикул.');
                }
            },
        ];
    }
}