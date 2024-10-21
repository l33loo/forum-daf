<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\User;

use App\Domain\User;
use App\Domain\User\UserRepository;
use Slick\Event\EventDispatcher;

/**
 * PromoteUserToAdminHandler
 *
 * @package App\Application\User
 */
final readonly class PromoteUserToAdminHandler
{


    public function __construct(
        private UserRepository $users,
        private EventDispatcher $dispatcher
    ) {
    }

    /**
     * Handles the command to promote a user to an admin role.
     *
     * @param PromoteUserToAdminCommand $command The command object for promoting user to admin
     * @return User The user entity after being promoted to admin
     */
    public function handle(PromoteUserToAdminCommand $command): User
    {
        $user = $this->users->withId($command->userId());
        $this->dispatcher->dispatchEventsFrom(
            $user->promoteToAdmin()
        );
        return $user;
    }
}
