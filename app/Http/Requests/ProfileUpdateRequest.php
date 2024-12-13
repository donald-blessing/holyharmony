<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\GenderEnum;
use App\Enums\RolesEnum;
use App\Http\Requests\Traits\CustomFormRequest;
use App\Models\Profile;
use App\Traits\UserTrait;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends CustomFormRequest
{
    use UserTrait;

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
            'stage_name' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique(Profile::class)->ignore($this->user()->id, 'user_id'),
            ],
            'photo' => [
                'nullable',
                'file',
                'mimes:jpg,png,jpeg', 'max:2048',
            ],
            'genre' => [
                'nullable',
                'array',
            ],
            'preferred_performance_location' => [
                'nullable',
                'string',
                'max:255',
            ],
            'bio' => [
                'nullable',
                'string',
            ],
            'phone' => [
                'required',
                'string',
                'max:15',
                Rule::unique(Profile::class)->ignore($this->user()->id, 'user_id'),
            ],
            'address' => [
                'nullable',
                'array',
            ],
            'special_skills' => [
                'nullable',
                'array',
            ],
            'preferred_event_types' => [
                'nullable',
                'array',
            ],
            'social_media' => [
                'nullable',
                'array',
            ],
            'play_instruments' => [
                'nullable',
                'array',
            ],
            'role' => [
                'required',
                'string',
                Rule::enum(RolesEnum::class),
            ],
            'date_of_birth' => ['nullable', 'date'],
            'gender'        => [
                'nullable', 'string',
                Rule::enum(GenderEnum::class),
            ],
        ];
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);

        return array_merge($data, ['user_id' => $this->user()->id]);
    }
}
