<?php


namespace Modules\Roomservice\Http\Requests;

use App\Http\Requests\FormRequest;

class RoomServiceItemRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    

    public function rules()
    {
        
        $rules['room_service_extra_price']   = ['nullable'];

        return $rules;
    }

}
