<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombre' => [
                'required', 'min:3'
            ],
            'direccion' => [
                'required', 'min:3'
            ],
            'telefono' => [
                'required', 'min:10'
            ],
            'points' => [
                'required',
            ],
            'double_points' => [
                'required',
            ],
            'logo' => 'image'
        ];
    }
}
