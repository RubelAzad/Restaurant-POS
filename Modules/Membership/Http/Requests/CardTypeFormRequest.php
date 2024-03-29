<?php

namespace Modules\Membership\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardTypeFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        $rules['name'] = ['required','string','unique:cardtypes,name'];
        if(request()->update_id){
            $rules['name'][2] = 'unique:cardtypes,name,'.request()->update_id;
        }
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
