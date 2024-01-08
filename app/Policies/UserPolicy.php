<?php

namespace App\Policies;

use App\User;
use App\Http\Sections\Users;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{

    use HandlesAuthorization;

    /**
     * @param User $user
     * @param string $ability
     * @param Users $section
     * @param User|null $item
     *
     * @return bool
     */

    public function before(User $user, string $ability, Users $section, User $item = null): bool
    {
        if ($user->isSuperAdmin()) {
            if ($ability != 'display' && $ability != 'create' && !is_null($item) && $item->id == 47) {
                return false;
            }

            return true;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Users $section
     * @param User $item
     *
     * @return bool
     */
    public function display(User $user, Users $section, User $item): bool
    {
        if ($user->isSuperAdmin() && $user->isManager()) {
            return true;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Users $section
     * @param User $item
     *
     * @return bool
     */
    public function create(User $user, Users $section, User $item): bool
    {
        return $item->id == 47;
    }

    /**
     * @param User $user
     * @param Users $section
     * @param User $item
     *
     * @return bool
     */
    public function edit(User $user, Users $section, User $item): bool
    {
        return $item->id != 47;
    }

    /**
     * @param User $user
     * @param Users $section
     * @param User $item
     *
     * @return bool
     */
    public function delete(User $user, Users $section, User $item): bool
    {
        return $item->id != 47;
    }

    /**
     * @param User $user
     * @param Users $section
     * @param User $item
     *
     * @return bool
     */
    public function restore(User $user, Users $section, User $item): bool
    {
        return true;
    }
}
