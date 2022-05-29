<?php

namespace Modules\Restaurant\Http\Requests;
use App\Http\Requests\FormRequest;



class RitemFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules                      = [];
        $rules['name']            = ['required','string'];
        $rules['image']             = ['nullable','image','mimes:png,jpg'];
        $rules['rcat_id']           = ['required','string'];
        $rules['price']             = ['required','numeric','gt:0'];
        $rules['qty']               = ['nullable','numeric','gte:0'];
        $rules['alert_qty']         = ['nullable','numeric','gte:0'];
        $rules['tax']               = ['nullable','numeric','gt:0'];
        $rules['description']       = ['nullable'];
        $rules['offer']             = ['nullable'];
        $rules['special']           = ['nullable'];
        $rules['op_rate']           = ['nullable'];
        $rules['os_date']           = ['nullable','date'];
        $rules['oe_date']           = ['nullable','date'];
        $rules['oc_time']           = ['nullable'];
        $rules['ri_menu']           = ['nullable'];
        $rules['notes']             = ['nullable'];
        $rules['components']        = ['nullable'];
        
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
