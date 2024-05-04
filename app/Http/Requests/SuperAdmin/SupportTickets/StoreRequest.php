<?php

namespace App\Http\Requests\SuperAdmin\SupportTickets;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'subject' => 'required',
            'description' => 'required',
            'priority' => 'sometimes|required',
            'requested_for' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'requested_for.required' => __('modules.tickets.requesterName').' '.__('app.required')
        ];
    }

}
