<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalculateTaxRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'total_income' => 'required|numeric',
            'resident' => 'required|numeric',
            'married' => 'required|numeric',
            'tot_spo_income' => 'required_if:married,'.config('constants.CHECKED'),
            'spo_resident' => 'required_if:married,'.config('constants.CHECKED'),
        ];
    }
    public function messages()
    {
        return [
            'tot_spo_income.required_if' => trans('tax.error_messages.tot_spo_income'),
            'spo_resident.required_if' => trans('tax.error_messages.spo_resident')
        ];
    }
}
