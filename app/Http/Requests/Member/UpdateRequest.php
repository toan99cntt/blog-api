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
            '_name' => 'string|min:8|max:30',
            '_phone_number' => [
                'nullable',
                'regex:' . config('validator.number'),
            ],
            '_dob' => [
                'nullable',
                'date_format:' . config('format.date_vn'),
            ],
            '_gender' => [
                'nullable',
                Rule::in([Member::MALE, Member::FE_MALE]),
            ],
            'avatar' => 'image|max:3072',
        ];
    }
}
