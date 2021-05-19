<?php

namespace App\Http\Requests;

use App\Web\UserHistoryDeposit;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use DB;

class BalanceRequest extends FormRequest
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
            'membership' => [
                'required', 'membership' => 'exists:App\User,username'
            ],
            'balance' => [
                'required', 'integer', 'min:100', 'exclude_if:balance,0'
            ],
            'station_id' => [
                'required'
            ],
            'image' => [
                'required', 'image', 'mimes:jpeg,bmp,png'
            ]
        ];
    }
}
