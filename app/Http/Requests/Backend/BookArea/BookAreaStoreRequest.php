<?php

namespace App\Http\Requests\Backend\BookArea;

use Illuminate\Foundation\Http\FormRequest;

class BookAreaStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'title' => ['required', 'string', 'max:255'],
            'short_title' => ['required', 'string', 'max:255'],
            'description' => [
                'required',
                'string',
                'min:10',
                'max:1000',
            ],
            'link' => ['required', 'url'],
            'status' => ['required', 'in:active,inactive'],
        ];
    }
}