<?php

namespace App\Http\Requests\Member;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Member;

class StoreRequest extends FormRequest
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
            '_name' => 'required|string|min:8|max:30',
            '_email' => [
                'required',
                'email:rfc',
                'max:255',
                Rule::unique('members', 'email'),
                'regex:' . config('validator.email'),
            ],
            '_password' => [
                'required',
                'string',
                'min:8',
                'max:16',
                'regex:' . config('validator.password'),
                function ($attr, $value, $fail) {
                    $check = preg_match(config('validator.check_space'), $value);
                    if (! $check) {
                        $fail('Mật khẩu không chứa khoảng trống.');
                    }
                }
            ],
            '_gender' => ['required',
                    Rule::in([Member::MALE, Member::FE_MALE]),],
        ];
    }
}
