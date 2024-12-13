<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Http\Requests\Traits\CustomFormRequest;
use App\Traits\UserTrait;
use Illuminate\Contracts\Validation\ValidationRule;

class ProfileImageUpdateRequest extends CustomFormRequest
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
            'photo' => [
                'required',
                'file',
                'mimes:jpg,png,jpeg', 'max:2048',
            ],

        ];
    }

    public function validated($key = null, $default = null) //@phpstan-ignore-line
    {
        $data = parent::validated($key, $default);

        return array_merge($data, ['user_id' => $this->user()->id]);
    }
}
