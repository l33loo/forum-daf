<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Web\User;

use App\Domain\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

/**
 * UserAwareControllerTrait
 *
 * @package App\UserInterface\Web\User
 */
trait UserAwareControllerTrait
{

    abstract protected function isGranted(mixed $attribute, mixed $subject = null): bool;

    /**
     * Retrieves a user object based on the provided user ID or the current user if no user ID is provided.
     *
     * @param Security $security The security service
     * @param string|null $userId The ID of the user to retrieve (default is null)
     * @return User The user object corresponding to the provided user ID or the current user
     */
    public function userFrom(Security $security, ?string $userId = null): User
    {
        if (!$userId) {
            return $this->loadCurrentUser($security);
        }

        $userId = new User\UserId($userId);
        $user = $this->users->withId($userId);
        if ($this->isGranted(User::ROLE_ADMIN)) {
            return $user;
        }

        return $user->userId()->equals($userId) ? $user : $this->loadCurrentUser($security);
    }

    /**
     * Retrieves the current user from the security context.
     *
     * @param Security $security The security component
     * @return User The current user
     * @throws UserNotFoundException If the current user is not found or is not an instance of User
     */
    private function loadCurrentUser(Security $security): User
    {
        $user = $security->getUser();
        if ($user instanceof User) {
            return $user;
        }

        throw new UserNotFoundException();
    }
}
