<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['nullable', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'status' => ['boolean'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'commission_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'settings' => ['nullable', 'array'],
            'settings.*' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vendor name is required',
            'description.required' => 'Vendor description is required',
            'contact_email.email' => 'Please enter a valid email address',
            'commission_rate.numeric' => 'Commission rate must be a number',
            'commission_rate.min' => 'Commission rate cannot be negative',
            'commission_rate.max' => 'Commission rate cannot exceed 100%',
        ];
    }
}
