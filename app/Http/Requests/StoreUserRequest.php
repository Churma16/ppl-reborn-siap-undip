<?php

namespace App\Http\Requests;

use App\Enums\userRole;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nip_nim' => 'required|string|unique:users,nip_nim',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:8',
            'role' => ['required', new Enum(userRole::class, 'name')],
        ];
    }
}
