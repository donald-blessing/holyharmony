<?php

declare(strict_types=1);

namespace App\Enums;

enum ApiResponseEvent: string
{
    case DefaultResponse            = 'DEFAULT_RESPONSE';
    case AppUpdatesRequiredResponse = 'APP_UPDATES_REQUIRED_RESPONSE';
    case LoginRequiredResponse      = 'LOGIN_REQUIRED_RESPONSE';
}
