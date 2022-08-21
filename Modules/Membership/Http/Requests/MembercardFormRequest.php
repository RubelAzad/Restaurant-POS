<?php

namespace Modules\Membership\Http\Requests;

use App\Http\Requests\FormRequest;

class MembercardFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        
        $rules['customer_id']   = ['required','string','unique:membercards'];
        $rules['card_id']       = ['required','string'];

        
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
