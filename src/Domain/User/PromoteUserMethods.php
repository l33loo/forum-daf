<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Event\User\UserWasDemotedFromAdmin;
use App\Domain\Event\User\UserWasPromotedToAdmin;

/**
 * PromoteUserMethods
 *
 * @package App\Domain\User
 */
trait PromoteUserMethods
{


    /**
     * Promotes the user to admin role
     *
     * @return self Returns an instance of the class with admin role added
     */
    public function promoteToAdmin(): self
    {
        $this->roles[] = self::ROLE_ADMIN;
        $this->recordThat(new UserWasPromotedToAdmin($this->userId));
        return $this;
    }

    /**
     * Demotes the user from admin role
     *
     * @return self The updated user entity
     */
    public function demoteFromAdmin(): self
    {
        $roles = array_filter($this->getRoles(), fn ($role) => $role !== self::ROLE_ADMIN);
        $this->roles = array_unique($roles);
        $this->recordThat(new UserWasDemotedFromAdmin($this->userId));
        return $this;
    }
}
