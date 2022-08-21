<?php


namespace Modules\Roomservice\Http\Requests;

use App\Http\Requests\FormRequest;

class GeneralRoomSettingsRequest extends FormRequest
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
        return [
            'room_service_charge_label'  => 'required|string',
            'room_service_type'  => 'required|string',
            'room_service_charge_percentage'  => 'nullable|numeric|gt:0',
            'room_service_charge_fixed'  => 'nullable|numeric|gt:0',
        ];
    }
}
