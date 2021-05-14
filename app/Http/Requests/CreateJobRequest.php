<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateJobRequest extends FormRequest
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
            'title' => 'required',
            'start_date' => 'required',
            'booking_start' => 'required',
            'booking_end' => 'required',
            'radius' => 'nullable|numeric',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'start' => 'nullable|date',
            'end' => 'nullable|date',
            'profession_id' => 'required',
            'direct_booking' => 'required'
        ];
    }
    
    public function messages()
    {
        return [
            'skills.required' => 'The professions field is required'
        ];
    }
}
