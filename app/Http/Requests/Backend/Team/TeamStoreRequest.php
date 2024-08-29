<?php

namespace App\Http\Requests\Backend\Team;

use Illuminate\Foundation\Http\FormRequest;

class TeamStoreRequest extends FormRequest
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
            'image' => ['required', 'image', 'mimes:png,jpg'],
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


/**
 *
 * 'facebook_url'  => ['nullable', 'regex:/^(https?:\/\/)?(www\.)?facebook.com\/[a-zA-Z0-9(\.\?)?]/'],
 *             'linkedin_url'  => ['nullable', 'regex:/^(https?:\/\/)?(www\.)?linkedin.com\/.*$/i'],
 *             'instagram_url' => ['nullable', 'regex:/^(https?:\/\/)?(www\.)?instagram.com\/[a-zA-Z0-9(\.\?)?]/'],
 *             'twitter_url'   => ['nullable', 'regex:/^(https?:\/\/)?(www\.)?twitter.com\/([a-zA-Z0-9_]+)/'],
 *
 */
