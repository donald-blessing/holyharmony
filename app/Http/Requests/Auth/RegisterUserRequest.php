<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\Http\Requests\Traits\CustomFormRequest;
use App\Models\User;
use App\Rules\UnauthorizedEmailProviders;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rules\Password;

class RegisterUserRequest extends CustomFormRequest
{
    /** Check if the name field is empty */
    protected function isNameEmpty(): bool
    {
        return blank($this->input('name'));
    }

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
            'name' => [
                'nullable',
                'string',
                'max:255',
                function (mixed $attribute, string $value, $fail): void {
                    // If name is empty, first_name and last_name become required
                    if ($value === '' || $value === '0') {
                        $firstNameExists = filled(request('first_name'));
                        $lastNameExists  = filled(request('last_name'));

                        if ( ! $firstNameExists || ! $lastNameExists) {
                            $fail('Either full name or both first and last names must be provided.');
                        }
                    }
                },
            ],
            'first_name' => [
                $this->isNameEmpty() ? 'required' : 'nullable',
                'string',
                'max:255',
            ],
            'last_name' => [
                $this->isNameEmpty() ? 'required' : 'nullable',
                'string',
                'max:255',
            ],

            'email' => [
                'required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class,
                new UnauthorizedEmailProviders,
            ],
            'password' => ['required', Password::defaults()],
        ];
    }

    public function validated($key = null, $default = null): array
    {
        $validated = parent::validated($key, $default);

        if (isset($validated['first_name'], $validated['last_name'])) {
            $validated['name'] = $validated['first_name'] . ' ' . $validated['last_name'];
        }

        return $validated;
    }
}
