<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTravelerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'full_name'      => ['required', 'string', 'max:255'],
            'passport_number'=> ['required', 'string', 'max:50'],
            'nationality'    => ['required', 'string', 'max:100'],
            'flight_number'  => ['required', 'string', 'regex:/^[A-Z]{2}\d{3,4}$/'],
            'departure_date' => ['required', 'date', 'after:today'],
            'destination'    => ['required', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'flight_number.regex'         => 'Flight number must be 2 uppercase letters followed by 3 or 4 digits (e.g. AB123).',
            'departure_date.after'=> 'Departure date cannot be in the past.',
        ];
    }
}
