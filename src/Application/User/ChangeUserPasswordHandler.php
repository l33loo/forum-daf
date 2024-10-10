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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

/**
 * ChangeUserPasswordHandler
 *
 * @package App\Application\User
 */
final readonly class ChangeUserPasswordHandler
{


    public function __construct(
        private UserRepository $users,
        private UserPasswordHasherInterface $hasher,
        private EventDispatcher $dispatcher
    ) {
    }

    public function handle(ChangeUserPasswordCommand $command): User
    {
        $user = $this->users->withId($command->userId());
        $hashedPassword = $this->hasher->hashPassword($user, $command->password());

        $this->dispatcher->dispatchEventsFrom($user->withPassword($hashedPassword));
        return $user;
    }


}
