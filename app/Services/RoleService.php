<?php

namespace App\Services;

use Spatie\Permission\Models\Role;

class RoleService
{
    /**
     * Get all roles
     */
    public function getAllRoles(): \Illuminate\Database\Eloquent\Collection
    {
        return Role::all();
    }

    /**
     * Check if role exists, create if not
     */
    public function ensureRoleExists(string $roleName): Role
    {
        return Role::firstOrCreate(['name' => $roleName]);
    }

    /**
     * Assign role to user
     */
    public function assignRoleToUser($user, string $roleName): void
    {
        $role = $this->ensureRoleExists($roleName);
        $user->assignRole($role);
    }
}

