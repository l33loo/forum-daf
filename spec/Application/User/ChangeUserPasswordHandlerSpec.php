<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\User;

use App\Application\User\ChangeUserPasswordCommand;
use App\Application\User\ChangeUserPasswordHandler;
use App\Domain\User;
use App\Domain\User\UserId;
use App\Domain\User\UserRepository;
use PhpSpec\ObjectBehavior;
use Slick\Event\EventDispatcher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * ChangeUserPasswordHandlerSpec specs
 *
 * @package spec\App\Application\User
 */
class ChangeUserPasswordHandlerSpec extends ObjectBehavior
{

    private $userId;
    private $plainPassword;
    private $hashedPassword;

    function let(
        UserRepository $users,
        UserPasswordHasherInterface $hasher,
        EventDispatcher $dispatcher,
        User $user
    ) {
        $this->userId = new UserId();
        $users->withId($this->userId)->willReturn($user);

        $this->plainPassword = 'some-password';
        $this->hashedPassword = 'some-hash';
        $hasher->hashPassword($user, $this->plainPassword)->willReturn($this->hashedPassword);

        $user->withPassword($this->hashedPassword)->willReturn($user);

        $dispatcher->dispatchEventsFrom($user)->willReturn([]);

        $this->beConstructedWith($users, $hasher, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ChangeUserPasswordHandler::class);
    }

    function it_handles_change_user_password(User $user, EventDispatcher $dispatcher)
    {
        $command = new ChangeUserPasswordCommand($this->userId, $this->plainPassword);
        $this->handle($command)->shouldBe($user);
        $user->withPassword($this->hashedPassword)->shouldHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($user)->shouldHaveBeenCalled();
    }
}