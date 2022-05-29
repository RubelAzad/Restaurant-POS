<?php

namespace Modules\Restaurant\Http\Requests;

use App\Http\Requests\FormRequest;

class RtableFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules['floor_id']  = ['required','integer'];
        $rules['name']         = ['required','string'];
        $rules['capacity']        = ['required','string'];
        $rules['image']        = ['nullable','image','mimes:jpg,png,jpeg'];

        
        return $rules;
    }

    public function messages()
    {
        return [
            'floor_id.required' => 'The department field is required',
            'floor_id.integer' => 'The department field value must be integer'
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
