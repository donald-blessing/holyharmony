<?php

declare(strict_types=1);

namespace App\Http\Requests\Traits;

use App\Http\Controllers\Api\Traits\HasApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class CustomFormRequest extends FormRequest
{
    use HasApiResponse;

    /** @throws ValidationException */
    protected function failedValidation(Validator $validator): void
    {
        throw new ValidationException(
            $validator,
            $this->sendErrorResponse('Validation error', $validator->errors(), 422)
        );
    }
}
