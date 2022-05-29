<?php

namespace Modules\Restaurant\Http\Requests;

use App\Http\Requests\FormRequest;

class RaddonassignFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules['fooditem_id'] = ['required'];
        $rules['addon_id']  = ['required'];
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
