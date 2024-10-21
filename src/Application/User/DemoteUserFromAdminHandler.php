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
 * DemoteUserFromAdminHandler
 *
 * @package App\Application\User
 */
final readonly class DemoteUserFromAdminHandler
{


    /**
     * Creates a DemoteUserFromAdminHandler
     *
     * @param UserRepository $users The UserRepository instance.
     * @param EventDispatcher $dispatcher The EventDispatcher instance.
     */
    public function __construct(
        private UserRepository $users,
        private EventDispatcher $dispatcher
    ) {
    }

    /**
     * Handles the DemoteUserFromAdminCommand by demoting the user from admin status
     *
     * @param DemoteUserFromAdminCommand $command The command to demote user from admin
     *
     * @return User The demoted user entity
     */
    public function handle(DemoteUserFromAdminCommand $command): User
    {
       $user = $this->users->withId($command->userId());
       $this->dispatcher->dispatchEventsFrom(
           $user->demoteFromAdmin()
       );

       return $user;
    }
}
