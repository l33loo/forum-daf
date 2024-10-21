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
use App\Domain\User;
use App\Domain\User\UserRepository;
use Slick\Event\EventDispatcher;

/**
 * BanUserHandler
 *
 * @package App\Application\User
 */
final readonly class BanUserHandler
{


    /**
     * Creates a BanUserHandler
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
     * Handles banning of a user based on the provided BanUserCommand.
     *
     * @param BanUserCommand $command The command containing information for banning the user
     * @return User The user entity after being banned
     * @throws DomainException
     */
    public function handle(BanUserCommand $command): User
    {
        $user = $this->users->withId($command->userId());
        $this->dispatcher->dispatchEventsFrom(
            $user->ban($command->reason())
        );

        return $user;
    }


}
