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
use App\Domain\User\Specification\NewUserSpecification;
use App\Domain\User\UserRepository;
use Slick\Event\EventDispatcher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * RegisterUserHandler
 *
 * @package App\Application\User
 */
final readonly class RegisterUserHandler
{


    /**
     * Creates a RegisterUserHandler
     *
     * @param UserRepository $users
     * @param NewUserSpecification $newUserSpec
     * @param UserPasswordHasherInterface $hasher
     * @param EventDispatcher $dispatcher
     * @param TranslatorInterface $translator
     */
    public function __construct(
        private UserRepository $users,
        private NewUserSpecification $newUserSpec,
        private UserPasswordHasherInterface $hasher,
        private EventDispatcher $dispatcher,
        private TranslatorInterface $translator,
    ) {
    }

    /**
     * Handles registering a new user based on the provided command
     *
     * @param RegisterUserCommand $command The command containing user registration data
     * @return User The newly registered user
     * @throws FailedSpecification If a user with the same email already exists
     */
    public function handle(RegisterUserCommand $command): User
    {
        $user = User::register($command->email(), $command->name());

        if (!$this->newUserSpec->isSatisfiedBy($user)) {
            throw new FailedSpecification(
                $this->translator->trans(
                    "A user with email '{mail}' already exists",
                    ['mail' => $command->email()]
                )
            );
        }

        $hashedPassword = $this->hasher->hashPassword($user, $command->password());
        $user->withPassword($hashedPassword);
        $this->dispatcher->dispatchEventsFrom(
            $this->users->add($user)
        );
        return $user;
    }
}
