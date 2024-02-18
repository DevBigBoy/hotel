<?php

namespace App\Http\Requests\Backend\RoomNumber;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RoomNumberUpdateRequest extends FormRequest
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
        $roomNumber = $this->route('room_number')->id;

        return [
            'room_id' => ['required', 'exists:rooms,id'],
            'room_number' => ['required', 'string', 'max:255', Rule::unique('room_numbers', 'room_number')->ignore($roomNumber)],
            'status' => ['required', 'in:available,occupied,maintenance'],

        ];
    }
}