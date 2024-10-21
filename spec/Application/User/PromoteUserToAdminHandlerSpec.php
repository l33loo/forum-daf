<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\User;

use App\Application\User\PromoteUserToAdminCommand;
use App\Application\User\PromoteUserToAdminHandler;
use App\Domain\User;
use App\Domain\User\UserRepository;
use PhpSpec\ObjectBehavior;
use Slick\Event\EventDispatcher;

/**
 * PromoteUserToAdminHandlerSpec specs
 *
 * @package spec\App\Application\User
 */
class PromoteUserToAdminHandlerSpec extends ObjectBehavior
{
    private $userId;

    function let(
        UserRepository $users,
        EventDispatcher $dispatcher,
        User $user
    ) {
        $this->userId = new User\UserId();
        $users->withId($this->userId)->willReturn($user);
        $user->userId()->willReturn($this->userId);
        $user->promoteToAdmin()->willReturn($user);
        $dispatcher->dispatchEventsFrom($user)->willReturn([]);

        $this->beConstructedWith($users, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PromoteUserToAdminHandler::class);
    }

    function it_handles_promote_user_to_admin(
        EventDispatcher $dispatcher,
        User $user
    ) {
        $command = new PromoteUserToAdminCommand($this->userId);
        $this->handle($command)->shouldBe($user);
        $user->promoteToAdmin()->shouldHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($user)->shouldHaveBeenCalled();
    }
}