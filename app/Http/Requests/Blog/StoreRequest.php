<?php

namespace App\Http\Requests\Blog;

use App\Models\Blog;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            '_title' => 'required|string|max:255',
            '_content' => 'required|string',
            '_status' => [
                'required',
                Rule::in([Blog::IS_PUBLISH, Blog::IS_DRAFT])
            ],
            '_image' => 'image|max:3072'
        ];
    }
}
