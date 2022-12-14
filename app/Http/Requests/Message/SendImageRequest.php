<?php

namespace App\Http\Requests\Message;

use Illuminate\Foundation\Http\FormRequest;

class SendImageRequest extends FormRequest
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
            'images' => 'required|array|max:3',
            'images.*' => 'image|max:3072'
        ];
    }
}
