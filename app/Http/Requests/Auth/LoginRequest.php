<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\Actions\LoginUserAction;
use App\Data\LoginUserData;
use App\Http\Requests\Traits\CustomFormRequest;
use App\Rules\UnauthorizedEmailProviders;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends CustomFormRequest
{
    /** Determine if the user is authorized to make this request. */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email'    => ['required', 'string', 'email', new UnauthorizedEmailProviders],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(): bool|array
    {
        //        $this->ensureIsNotRateLimited();

        //get either username or password
        $credentials = $this->only('email', 'password');

        //        RateLimiter::clear($this->throttleKey());

        return LoginUserAction::handle(LoginUserData::from($credentials));
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if ( ! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /** Get the rate limiting throttle key for the request. */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('email')) . '|' . $this->ip());
    }
}
