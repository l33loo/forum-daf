<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\DomainException;
use App\Domain\Exception\EntityNotFound;
use App\Domain\User;

/**
 * UserRepository
 *
 * @package App\Domain\User
 */
interface UserRepository
{

    /**
     * Adds a user to the repository
     *
     * @param User $user The user to be added
     * @return User The added user
     */
    public function add(User $user): User;

    /**
     * Sets the user with the given user ID
     *
     * @param UserId $userId The ID of the user to be set
     * @return User The user with the specified user ID
     * @throws EntityNotFound|DomainException When no user is found for provided identifier
     */
    public function withId(UserId $userId): User;

    /**
     * Retrieves a user by email address
     *
     * @param Email $email The email address of the user to be retrieved
     * @return User The user with the provided email address
     * @throws EntityNotFound|DomainException When no user is found for provided identifier
     */
    public function withEmail(Email $email): User;
}
