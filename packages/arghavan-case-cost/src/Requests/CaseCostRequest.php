<?php

namespace Arghavan\CaseCost\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CaseCostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'case_number' => ['required', 'string', 'max:255'],
        ];
    }
}
