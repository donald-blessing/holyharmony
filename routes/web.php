<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::get('/', function (): array {
    return ['Laravel' => app()->version()];
});
