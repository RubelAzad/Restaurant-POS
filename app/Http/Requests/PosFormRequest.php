<?php
namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class PosFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        $rules['name'] = ['required','string','unique:pos_permissions,name'];
        if(request()->update_id){
            $rules['name'][2] = 'unique:pos_permissions,name,'.request()->update_id;
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
