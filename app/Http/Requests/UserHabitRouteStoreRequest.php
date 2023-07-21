<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserHabitRouteStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "habit_id"          => "nullable|exists:habbits,id",
            "habit"             => "required|max:255",
            "habit_description" => "required|max:500",
            "routine_time"      => "required|date_format:H:i:s",
            "routine_type"      => "required|in:".implode(",", config("modules.routine_types")),
        ];
    }
    public function attributes()
    {
        return [];
        return [
            "habit"             => "title",
            "habit_description" => "note",
        ];
    }
}
