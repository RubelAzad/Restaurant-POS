<?php

namespace Modules\Restaurant\Http\Requests;

use App\Http\Requests\FormRequest;

class RdiscountFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        
        $rules['food_id']       = ['required','string'];
        $rules['df_date']       = ['required','date'];
        $rules['dt_date']       = ['required','date'];
        $rules['df_time']       = ['required'];
        $rules['dt_time']       = ['required'];
        $rules['price']         = ['required','numeric','gt:0'];

        return $rules;
    }

    public function messages()
    {
        return [
            'food_id.required' => 'The Item field is required'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}


