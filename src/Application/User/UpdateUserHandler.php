<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\User;

use App\Domain\Exception\FailedSpecification;
use App\Domain\User;
use App\Domain\User\Specification\EmailNotUsedByAnotherUserSpecification;
use App\Domain\User\UserRepository;
use Slick\Event\EventDispatcher;
use Symfony\Contracts\Translation\TranslatorInterface;

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
     * @param EmailNotUsedByAnotherUserSpecification $notInUse
     * @param EventDispatcher $dispatcher The EventDispatcher instance to be injected
     */
    public function __construct(
        private UserRepository $users,
        private EmailNotUsedByAnotherUserSpecification $notInUse,
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
        $testUser = clone $user;
        $testUser = $testUser->update($command->name(), $command->email());
        if (!$this->notInUse->isSatisfiedBy($testUser)) {
            throw new FailedSpecification(
        "The email address you entered is already in use by another account."
            );
        }
        $this->dispatcher->dispatchEventsFrom(
            $user->update($command->name(), $command->email())
        );

        return $user;
    }


}
