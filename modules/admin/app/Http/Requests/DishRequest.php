<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DishRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "name" => "required|string",
            "description" => "nullable|string",
            "menu_id" => "required|exists:menus,id",
            "photo" => "nullable|image",
            "category_id" => "required|exists:categories,id",
            "is_vegetarian" => "nullable",
            "price" => "required|numeric",
        ];
    }
}
