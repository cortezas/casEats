<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreComidaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //formas distintas de poner varias reglas
            "nombre" => ["required","min:5"],//forma 1
            "email" => "email|min:5",//forma 2
            "dni" => "required",
            "dir" => "required"
        ];
    }
}
