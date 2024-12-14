<?php

declare(strict_types=1);

namespace App\Providers;

use App\Enums\RolesEnum;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Spatie\LaravelMorphMapGenerator\MorphMapGenerator;

class AppServiceProvider extends ServiceProvider
{
    /** Register any application services. */
    public function register(): void {}

    /** Bootstrap any application services. */
    public function boot(): void
    {
        MorphMapGenerator::resolveUsing(fn ($model) => ucfirst((Str::singular($model->getTable()))));

        // Implicitly grant "Super Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user, $ability) {
            return $user->hasRole(RolesEnum::SuperAdmin->value) ? true : null;
        });

        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url') . "/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
    }
}
