<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\User;

use App\Application\User\RegisterUserCommand;
use App\Application\User\RegisterUserHandler;
use App\Domain\Exception\FailedSpecification;
use App\Domain\User;
use App\Domain\User\Specification\NewUserSpecification;
use App\Domain\User\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slick\Event\EventDispatcher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * RegisterUserHandlerSpec specs
 *
 * @package spec\App\Application\User
 */
class RegisterUserHandlerSpec extends ObjectBehavior
{
    private $plainPassword;
    private $hashedPassword;

    function let(
        UserRepository $users,
        NewUserSpecification $newUserSpec,
        EventDispatcher $dispatcher,
        UserPasswordHasherInterface $hasher,
        TranslatorInterface $translator
    ) {
        /** @var User|Argument\Token\TypeToken $user */
        $user = Argument::type(User::class);
        $users->add($user)->willReturnArgument();
        $dispatcher->dispatchEventsFrom($user)->willReturn([]);
        $newUserSpec->isSatisfiedBy($user)->willReturn(true);
        $this->plainPassword = 'plain_text_password';
        $this->hashedPassword = 'hashed_password';
        $hasher->hashPassword($user, $this->plainPassword)->willReturn($this->hashedPassword);
        $translator->trans(Argument::type('string'), Argument::type("array"))->willReturnArgument();
        $this->beConstructedWith($users, $newUserSpec, $hasher, $dispatcher, $translator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RegisterUserHandler::class);
    }

    function it_handles_user_registration(
        UserRepository $users,
        EventDispatcher $dispatcher,
    ) {
        $command = new RegisterUserCommand(new User\Email('john.doe@example.com'), 'John Doe', $this->plainPassword);
        $user = $this->handle($command);
        $user->shouldBeAnInstanceOf(User::class);
        $user->getPassword()->shouldBe($this->hashedPassword);
        $users->add($user)->shouldHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($user)->shouldHaveBeenCalled();
    }

    function it_throws_exception_when_user_already_exists(NewUserSpecification $newUserSpec)
    {
        $newUserSpec->isSatisfiedBy(Argument::type(User::class))->willReturn(false);
        $command = new RegisterUserCommand(new User\Email('john.doe@example.com'), 'John Doe', $this->plainPassword);
        $this->shouldThrow(FailedSpecification::class)
            ->during('handle', [$command]);
    }
}