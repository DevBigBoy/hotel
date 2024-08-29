<?php

namespace App\Http\Requests\Backend\Team;

use Illuminate\Foundation\Http\FormRequest;

class TeamUpdateRequest extends FormRequest
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
            'image' => ['nullable', 'image', 'mimes:png,jpg'],
            'name' => ['required', 'string'],
            'postion' => ['required', 'string', 'max:255'],
            'facebook_url'  => ['nullable', 'url'],
            'linkedin_url'  => ['nullable', 'url'],
            'instagram_url' => ['nullable', 'url'],
            'twitter_url'   => ['nullable', 'url'],
            'status' => ['required', 'in:active,inactive'],
        ];
    }
}
