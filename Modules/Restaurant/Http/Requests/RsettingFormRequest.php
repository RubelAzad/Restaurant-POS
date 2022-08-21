<?php

namespace Modules\Restaurant\Http\Requests;

use App\Http\Requests\FormRequest;

class RsettingFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules['menu_type']   = ['required','string'];
        $rules['sc_time']     = ['required','string'];
        $rules['ec_time']     = ['required','string'];

        
        return $rules;
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
