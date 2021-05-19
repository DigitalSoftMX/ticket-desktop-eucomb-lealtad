<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminRequest extends FormRequest
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
            'name' => [
                'required', 'min:3'
            ],
            'first_surname' => [
                'required', 'min:3'
            ],
            'second_surname' => [
                'required', 'min:3'
            ],
            'phone' => [
                'required', 'min:10'
            ],
            'email' => [
                'required', 'email', Rule::unique((new User)->getTable())->ignore($this->route()->admin ?? null)
            ],
            'password' => [
                $this->route()->admin ? 'required_with:password_confirmation' : 'required', 'nullable', 'confirmed', 'min:6'
            ],
        ];
    }
}
