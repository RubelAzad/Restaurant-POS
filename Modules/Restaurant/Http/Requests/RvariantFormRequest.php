<?php

namespace Modules\Restaurant\Http\Requests;

use App\Http\Requests\FormRequest;

class RvariantFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules['item_id']  = ['required','integer'];
        $rules['name']     = ['required','string'];
        $rules['price']    = ['required','numeric','gt:0'];

        
        return $rules;
    }

    public function messages()
    {
        return [
            'item_id.required' => 'The department field is required'
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
