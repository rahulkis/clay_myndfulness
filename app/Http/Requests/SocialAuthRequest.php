<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class SocialAuthRequest extends FormRequest
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
            "name"              => "nullable|string|max:100",
            "email"             => "nullable|string|max:100",
            "social_auth_type"  => "required|in:google,apple",
            "social_auth_token" => "required",
        ];
    }
    public function prepareData(): array
    {
        return $this->all();
        // $data = $this->all(array_keys($this->rules()));
        // return array_merge($data, $extra_data);
    }
}
