<?php

namespace Modules\Membership\Http\Requests;

use App\Http\Requests\FormRequest;

class CardFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        
        $rules['name']                  = ['string'];
        $rules['card_type']                  = ['required'];
        $rules['card_id']                  = ['string'];
        $rules['card_member_id']         = ['required','string'];
        $rules['card_facilities_id']    = ['required'];
        $rules['card_min_value']        = ['required','numeric','gt:0'];
        $rules['card_trash_hold']       = ['required','numeric','gt:0'];
        $rules['room_access']         = ['nullable','string'];
        $rules['image']             = ['image','mimes:png,jpg'];
        
        

        return $rules;
    }

    public function messages()
    {
        return [
            'card_min_value.required' => 'The Card Minimum Value is required',
            'card_min_value.numeric' => 'The Card Value Must be Numeric',
            'card_trash_hold.required' => 'The Card Trash Hold Value is required',
            'card_trash_hold.numeric' => 'The Card Trash Hold Value Numeric',
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
