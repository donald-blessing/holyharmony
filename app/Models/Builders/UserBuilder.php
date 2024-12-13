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
        return $this->whereHas('roles', function (\Illuminate\Contracts\Database\Query\Builder $query) use ($role): void {
            $query->where('name', $role);
        });
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
    public function soloActs(): Builder
    {
        return $this->role(RolesEnum::SoloAct->value);
    }

    /** Retrieve all band or choir members. */
    public function bandChoirs(): Builder
    {
        return $this->role(RolesEnum::BandChoir->value);
    }

    /** Retrieve all event bookers. */
    public function eventBookers(): Builder
    {
        return $this->role(RolesEnum::EventBooker->value);
    }

    public function performers(): Builder
    {
        return $this->whereHas('roles', function (\Illuminate\Contracts\Database\Query\Builder $query): void {
            $query->whereIn('name', [RolesEnum::SoloAct->value, RolesEnum::BandChoir->value]);
        });
    }

    /** Retrieve all clients. */
    public function clients(): Builder
    {
        return $this->role(RolesEnum::Client->value);
    }
}
