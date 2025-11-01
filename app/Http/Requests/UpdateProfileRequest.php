<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone' => 'required|string|min:10|max:12',
            'location' => 'required|in:Jakarta - Kemanggisan,Jakarta - Syahdan,Jakarta - Senayan,Tangerang - Alam Sutera,Bekasi,Bandung,Semarang,Malang,Medan',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional photo in general profile update
        ];

        // Only allow email updates for unverified users
        if ($this->user()->email_verified_at === null) {
            $rules['email'] = [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->user()->id),
                'regex:/^[a-zA-Z0-9._%+-]+@(binus\.ac\.id|binus\.edu)$/'
            ];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'The first name field is required.',
            'first_name.max' => 'The first name may not be greater than 50 characters.',
            'last_name.required' => 'The last name field is required.',
            'last_name.max' => 'The last name may not be greater than 50 characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'email.regex' => 'The email must be a valid binus.ac.id or binus.edu address.',
            'phone.required' => 'The phone number field is required.',
            'phone.min' => 'The phone number must be at least 10 characters.',
            'phone.max' => 'The phone number may not be greater than 12 characters.',
            'location.required' => 'The location field is required.',
            'location.in' => 'The selected location is invalid.',
            'photo.image' => 'The file must be an image.',
            'photo.mimes' => 'The photo must be a file of type: jpeg, png, jpg, gif.',
            'photo.max' => 'The photo may not be greater than 2MB.',
        ];
    }
}
