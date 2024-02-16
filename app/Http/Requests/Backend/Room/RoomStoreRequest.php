<?php

namespace App\Http\Requests\Backend\Room;

use Illuminate\Foundation\Http\FormRequest;

class RoomStoreRequest extends FormRequest
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
            'room_type_id' => ['required', 'exists:room_types,id', 'unique:rooms,room_type_id'],
            'total_adults' => ['required', 'integer', 'min:0'],
            'total_children' => ['required', 'integer', 'min:0'],
            'capacity' => ['required', 'integer', 'min:0'],
            'image' => ['required', 'image', 'max:2024', 'mimes:jpeg,png,jpg,gif,svg'],
            'price_per_night' => ['required', 'numeric', 'min:0'],
            'size' => ['required', 'string', 'max:50'],
            'view' => ['required', 'in:see,hill'],
            'bed_style' => ['required', 'in:queen,twin,king'],
            'discount' => ['required', 'integer', 'min:0', 'max:100'],
            'short_desc' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:available,archived'],
        ];
    }
}