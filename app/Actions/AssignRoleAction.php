<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;
use Spatie\Permission\Models\Role;

class AssignRoleAction
{
    public static function handle(User $user, string $role): void
    {
        $user->syncRoles(Role::query()->where('name', $role)->first());
    }
}
