<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ValidPhoneNumber;

class UserInfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'max:255', 'min:2', 'string'],
            'last_name' => ['required', 'max:255', 'min:2', 'string'],
            'country' => ['required', 'max:255', 'min:2', 'string'],
            'phone' => ['required', new ValidPhoneNumber],
            'email' => ['required', 'email:rfc,dns', 'max:255'],
            'transactionId' => ['nullable', 'max:255'],
        ];
    }
}
