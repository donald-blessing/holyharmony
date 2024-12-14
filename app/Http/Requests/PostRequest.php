<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\CategoryEnum;
use App\Http\Requests\Traits\CustomFormRequest;
use App\Services\FileValidationService;
use App\Traits\UserTrait;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;

class PostRequest extends CustomFormRequest
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
            'description' => [
                'nullable',
                'string',
            ],
            'category' => ['required', 'string', new Enum(CategoryEnum::class)],
            'upload'   => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,mp4,avi,mov,mp3,wav,ogg,flac,webm,mkv',
                'max:2048',
            ],
        ];
    }

    public function validated($key = null, $default = null): array // @phpstan-ignore-line
    {
        $data = parent::validated($key, $default);

        $fileValidation = new FileValidationService();

        $file = $data('upload');

        $data['is_downloadable'] = ! $fileValidation->validateImage($file);

        $data['user'] = self::getAuthUser();

        return $data;
    }
}
