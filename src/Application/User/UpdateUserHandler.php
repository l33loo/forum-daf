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
 * UpdateUserHandler
 *
 * @package App\Application\User
 */
final readonly class UpdateUserHandler
{


    /**
     * Creates update user handler.
     *
     * @param UserRepository $users The UserRepository instance to be injected
     * @param EventDispatcher $dispatcher The EventDispatcher instance to be injected
     */
    public function __construct(
        private UserRepository $users,
        private EventDispatcher $dispatcher
    ) {
    }

    /**
     * Handles the update user command.
     *
     * @param UpdateUserCommand $command The command containing data for updating a user
     *
     * @return User The updated User entity
     */
    public function handle(UpdateUserCommand $command): User
    {
        $user = $this->users->withId($command->userId());
        $this->dispatcher->dispatchEventsFrom(
            $user->update($command->name(), $command->email())
        );

        return $user;
    }


}
