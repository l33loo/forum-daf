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
 * CreateUserHandler
 *
 * @package App\Application\User
 */
final readonly class CreateUserHandler
{

    /**
     * Creates a creates user handler
     *
     * @param UserRepository $users The UserRepository instance.
     * @param EventDispatcher $dispatcher The EventDispatcher instance.
     */
    public function __construct(
        private UserRepository  $users,
        private EventDispatcher $dispatcher
    ) {
    }

    /**
     * Handles creating a new user based on the provided command
     *
     * @param CreateUserCommand $command The command containing user details.
     * @return User The newly created User instance.
     */
    public function handle(CreateUserCommand $command): User
    {
        $user = $this->users->add(
            new User($command->email(), $command->name())
        );
        $this->dispatcher->dispatchEventsFrom($user);
        return $user;
    }
}
