<?php

namespace App\Http\Requests\Member;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Member;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:8|max:30',
            'phone_number' => [
                'nullable',
                'regex:' . config('validator.number'),
            ],
            'dob' => [
                'nullable',
                'date_format:' . config('format.date_vn'),
            ],
            'gender' => [
                'nullable',
                Rule::in([Member::MALE, Member::FE_MALE]),
            ],
        ];
    }
}
