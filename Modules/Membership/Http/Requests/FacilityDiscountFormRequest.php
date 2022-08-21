<?php

namespace Modules\Membership\Http\Requests;

use App\Http\Requests\FormRequest;

class FacilityDiscountFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        
        $rules['facilities_member_id']              = ['required'];
        $rules['facilities_discount_id']            = ['required'];
        $rules['facilities_discount_price']         = ['required','numeric','gt:0'];
        $rules['facilities_discount_type']          = ['required','string'];
        $rules['facilities_discount_percentage']    = ['numeric','gt:0'];
        $rules['facilities_discount_fixed']         = ['numeric','gt:0'];
        $rules['facilities_discount_offer_price']   = ['nullable','gt:0'];
        $rules['facilities_discount_start_date']    = ['required','date'];
        $rules['facilities_discount_end_date']      = ['required','date'];
       
        
        
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
