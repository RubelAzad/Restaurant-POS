<?php

namespace Modules\Restaurant\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RaddonFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        $rules['name'] = ['required','string','unique:raddons,name'];
        if(request()->update_id){
            $rules['name'][2] = 'unique:raddons,name,'.request()->update_id;
        }
        $rules['price']    = ['required','numeric','gt:0'];
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
