<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\User;

use App\Application\User\RemoveUserAccountCommand;
use App\Application\User\RemoveUserAccountHandler;
use App\Domain\Event\User\UserAccountWasRemoved;
use App\Domain\User;
use App\Domain\User\UserId;
use App\Domain\User\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slick\Event\EventDispatcher;

/**
 * RemoveUserAccountHandlerSpec specs
 *
 * @package spec\App\Application\User
 */
class RemoveUserAccountHandlerSpec extends ObjectBehavior
{

    private $userId;

    function let(
        UserRepository $users,
        EventDispatcher $dispatcher,
        User $user
    ) {

        $this->userId = new UserId();
        $users->withId($this->userId)->willReturn($user);
        $users->remove($user)->willReturn($user);
        $user->userId()->willReturn($this->userId);
        $dispatcher->dispatch(Argument::type(UserAccountWasRemoved::class))->willReturnArgument();
        $this->beConstructedWith($users, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RemoveUserAccountHandler::class);
    }

    function it_handle_remove_user_command(
        UserRepository $users,
        EventDispatcher $dispatcher,
        User $user
    ) {
        $command = new RemoveUserAccountCommand($this->userId);
        $this->handle($command)->shouldBe($user);
        $users->remove($user)->shouldBeCalled();
        $dispatcher->dispatch(Argument::type(UserAccountWasRemoved::class))->shouldBeCalled();
    }
}