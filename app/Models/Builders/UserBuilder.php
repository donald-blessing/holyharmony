<?php

declare(strict_types=1);

namespace App\Models\Builders;

use App\Enums\RolesEnum;
use Illuminate\Database\Eloquent\Builder;

class UserBuilder extends Builder
{
    public function __construct(\Illuminate\Database\Query\Builder $query)
    {
        parent::__construct($query);
    }

    /** Retrieve all users with the specified role. */
    protected function role(string $role): Builder
    {
        return $this->whereHas(
            'roles',
            function (\Illuminate\Contracts\Database\Query\Builder $query) use ($role): void {
                $query->where('name', $role);
            }
        );
    }

    /** Retrieve all admins. */
    public function admins(): Builder
    {
        return $this->role(RolesEnum::Admin->value);
    }

    /** Retrieve all super admins. */
    public function superAdmins(): Builder
    {
        return $this->role(RolesEnum::SuperAdmin->value);
    }

    /** Retrieve all solo acts. */
    public function members(): Builder
    {
        return $this->role(RolesEnum::Member->value);
    }

    /** Retrieve all band or choir members. */
    public function artistes(): Builder
    {
        return $this->role(RolesEnum::Artiste->value);
    }

    /** Retrieve all event bookers. */
    public function ministries(): Builder
    {
        return $this->role(RolesEnum::Ministry->value);
    }
}
