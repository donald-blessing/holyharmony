<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\Http\Requests\Traits\CustomFormRequest;
use App\Models\User;
use App\Rules\UnauthorizedEmailProviders;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rules\Password;

class RegisterUserRequest extends CustomFormRequest
{
    /** Determine if the user is authorized to make this request. */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:' . User::class],
            'email'    => [
                'required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class,
                new UnauthorizedEmailProviders,
            ],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }
}
