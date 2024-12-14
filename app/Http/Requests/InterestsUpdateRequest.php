<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Http\Requests\Traits\CustomFormRequest;
use App\Models\User;
use App\Traits\UserTrait;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class InterestsUpdateRequest extends CustomFormRequest
{
    use UserTrait;

    /** Determine if the user is authorized to make this request. */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'interests' => [
                'required',
                'array',
            ],
        ];
    }

    public function validated($key = null, $default = null): array // @phpstan-ignore-line
    {
        $data = parent::validated($key, $default);

        type($this->user())->as(User::class)->update([
            'username' => $data['username'],
        ]);

        return array_merge($data, ['user_id' => $this->user()->id]);
    }
}
