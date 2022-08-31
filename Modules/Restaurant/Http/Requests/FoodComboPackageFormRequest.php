<?php

namespace Modules\Restaurant\Http\Requests;
use App\Http\Requests\FormRequest;



class FoodComboPackageFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules                    = [];
        $rules['name']            = ['required'];
        $rules['item_name']       = ['required'];
        $rules['event_type']      = ['required'];
        $rules['image']           = ['nullable','image','mimes:png,jpg'];
        $rules['price']           = ['required','numeric','gt:0'];

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
