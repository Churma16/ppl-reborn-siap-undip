<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        // Ambil parameter dari route
        $routeUser = $this->route('user');

        // Cek: Apakah ini Objek User? Atau cuma String ID?
        // Jika Objek User, ambil nip_nim-nya. Jika String, pakai langsung string-nya.
        $idToBeIgnored = $routeUser instanceof User ? $routeUser->nip_nim : $routeUser;

        return [
            'nip_nim' => [
                'required',
                'string',
                // Gunakan variabel ID yang sudah kita amankan di atas
                Rule::unique('users', 'nip_nim')->ignore($idToBeIgnored, 'nip_nim'),
            ],

            'username' => [
                'required',
                'string',
                Rule::unique('users', 'username')->ignore($idToBeIgnored, 'nip_nim'),
            ],

            'password' => 'nullable|string|min:8',
            'role' => ['required', new Enum(UserRole::class)],
        ];
    }
}
