<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\User;

use App\Domain\DomainException;
use App\Domain\Event\User\UserAccountWasRemoved;
use App\Domain\Exception\EntityNotFound;
use App\Domain\User;
use App\Domain\User\UserRepository;
use Slick\Event\EventDispatcher;

/**
 * RemoveUserAccountHandler
 *
 * @package App\Application\User
 */
final readonly class RemoveUserAccountHandler
{


    /**
     * Creates a RemoveUserAccountHandler
     *
     * @param UserRepository $users
     * @param EventDispatcher $dispatcher
     */
    public function __construct(
        private UserRepository $users,
        private EventDispatcher $dispatcher
    ) {
    }

    /**
     * Handles user remove command
     *
     * @param RemoveUserAccountCommand $command
     * @return User
     * @throws DomainException|EntityNotFound
     */
    public function handle(RemoveUserAccountCommand $command): User
    {
        $user = $this->users->withId($command->userId());
        $this->users->remove($user);
        $this->dispatcher->dispatch(new UserAccountWasRemoved($user->userId()));
        return $user;
    }
}
