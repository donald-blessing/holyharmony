<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\RolesEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /** Run the database seeds. */
    public function run(): void
    {
        foreach (RolesEnum::toArray() as $role) {
            Role::create([
                'name'  => $role,
                'guard' => 'web',
            ]);
        }
    }
}
