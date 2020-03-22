<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssetModelPolicy
{
    use HandlesAuthorization;
    protected function getPermission($user,$Permission_id)
    {
        foreach ($user->roles as $role) {
            foreach ($role->permissions as $permission) {
                if ($permission->id == $Permission_id) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Determine whether the user can view the role.
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        return $this->getPermission($user,17);
    }

    /**
     * Determine whether the user can create roles.
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $this->getPermission($user,18);
    }

    /**
     * Determine whether the user can update the role.
     * @param User $user
     * @return bool
     */
    public function update(User $user)
    {
        return $this->getPermission($user,19);
    }

    /**
     * Determine whether the user can delete the role.
     * @param User $user
     * @return bool
     */
    public function delete(User $user)
    {
        return $this->getPermission($user,20);
    }
}
