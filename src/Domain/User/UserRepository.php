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

    /**
     * Retrieves the email confirmation token for a given token
     *
     * @param string $token The email confirmation token to search for
     * @return EmailConfirmationRequest The EmailConfirmationRequest
     * @throws EntityNotFound|DomainException When no token is found for provided identifier
     */
    public function emailConfirmationToken(string $token): EmailConfirmationRequest;

    /**
     * Returns the currently logged-in user
     *
     * @return User The currently logged-in user
     * @throws EntityNotFound|DomainException When no user is currently logged-in
     */
    public function currentLoggedInUser(): User;

    public function update($argument1, $argument2);
}
