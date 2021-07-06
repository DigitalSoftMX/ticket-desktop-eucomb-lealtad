<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DispatcherRequest extends FormRequest
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
            'sex' => [
                'required'
            ],
            'email' => [
                'required', 'email', Rule::unique((new User)->getTable())->ignore($this->route()->user->id ?? null)
            ],
            'password' => [
                $this->route()->user ? 'required_with:password_confirmation' : 'required', 'nullable', 'confirmed', 'min:6'
            ],
            'schedule_id' => 'required',
            'island_id' => 'required'
        ];
    }
}
