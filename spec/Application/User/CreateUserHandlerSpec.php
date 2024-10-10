<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\User;

use App\Application\User\CreateUserCommand;
use App\Application\User\CreateUserHandler;
use App\Domain\User;
use App\Domain\User\Email;
use App\Domain\User\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slick\Event\EventDispatcher;

/**
 * CreateUserHandlerSpec specs
 *
 * @package spec\App\Application\User
 */
class CreateUserHandlerSpec extends ObjectBehavior
{

    function let(UserRepository $users, EventDispatcher $dispatcher)
    {
        $users->add(Argument::type(User::class))->willReturnArgument();
        $dispatcher->dispatchEventsFrom(Argument::type(User::class))->willReturn([]);

        $this->beConstructedWith($users, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CreateUserHandler::class);
    }

    function it_handles_a_create_user(UserRepository $users, EventDispatcher $dispatcher)
    {
        $command = new CreateUserCommand(new Email('test@test.com'), 'John Doe');
        $user = $this->handle($command);
        $user->shouldBeAnInstanceOf(User::class);
        $users->add($user)->shouldHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($user)->shouldHaveBeenCalled();
    }
}