<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAvailabilityRequest extends FormRequest
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
            'availability_title' => 'required|string',
            'availability_content'    => 'required|string',
            'start_date' => 'required|array',
            'end_date' => 'required|array',
            'booking_start' => 'required',
            'booking_end' => 'required',
            'event_id' => 'integer',
        ];
    }
}
