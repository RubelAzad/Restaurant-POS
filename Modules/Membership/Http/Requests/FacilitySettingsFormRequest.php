<?php

namespace Modules\Membership\Http\Requests;

use App\Http\Requests\FormRequest;

class FacilitySettingsFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        
        $rules['facilities_id']   = ['required','unique:facilitysettings'];
        $rules['facilities_price']        = ['required','numeric','gt:0'];
        $rules['facilities_status']       = ['required','string'];
        
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
