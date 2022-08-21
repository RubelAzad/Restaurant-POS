<?php


namespace Modules\CardSettings\Http\Requests;

use App\Http\Requests\FormRequest;

class GeneralCardSettingsFormRequest extends FormRequest
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
            'title'             => 'nullable|string',
            'card_prefix'      => 'nullable|string',
            'card_number'     => 'nullable|string',
            'card_number_format'  => 'nullable|string',
            'card_random_format' => 'nullable|string',
            'card_random_generate' => 'nullable|string',

            
            
        ];
    }
}
