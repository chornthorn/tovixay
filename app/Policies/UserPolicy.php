<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
     * Determine whether the user can view the user.
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        return $this->getPermission($user,5);
    }

    /**
     * Determine whether the user can create users.
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $this->getPermission($user,6);
    }

    /**
     * Determine whether the user can update the user.
     * @param User $user
     * @return bool
     */
    public function update(User $user)
    {
        return $this->getPermission($user,7);
    }

    /**
     * Determine whether the user can delete the user.
     * @param User $user
     * @return bool
     */
    public function delete(User $user)
    {
        return $this->getPermission($user,8);
    }
}
