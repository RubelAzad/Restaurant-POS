<?php

namespace Modules\Maintenance\Http\Requests;
use App\Http\Requests\FormRequest;



class TaskFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules                      = [];
        $rules['name']              = ['required','string'];
        $rules['employee_id']       = ['required','string'];
        $rules['type_id']           = ['required','string'];
        $rules['task_floor']        = ['nullable'];
        $rules['task_room']         = ['nullable'];
        $rules['description']       = ['required'];
        $rules['assign_dt']         = ['required'];
        $rules['schedule_dt']       = ['nullable'];
        $rules['assign_hours']      = ['required','string'];
        $rules['before_image']      = ['nullable','image','mimes:png,jpg'];
        $rules['after_image']      = ['nullable','image','mimes:png,jpg'];
        $rules['assign_by']         = ['required','string'];
        $rules['reported_by']       = ['nullable'];
        $rules['completed_dt']      = ['nullable'];
        $rules['command']           = ['nullable'];
        $rules['completed_hours']   = ['nullable'];
        
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
