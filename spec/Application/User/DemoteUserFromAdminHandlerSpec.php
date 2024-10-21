<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\User;

use App\Application\User\DemoteUserFromAdminCommand;
use App\Application\User\DemoteUserFromAdminHandler;
use App\Domain\User;
use App\Domain\User\UserRepository;
use PhpSpec\ObjectBehavior;
use Slick\Event\EventDispatcher;

/**
 * DemoteUserFromAdminHandlerSpec specs
 *
 * @package spec\App\Application\User
 */
class DemoteUserFromAdminHandlerSpec extends ObjectBehavior
{

    private $userId;

    function let(
        UserRepository $users,
        EventDispatcher $dispatcher,
        User $user
    ) {
        $this->userId = new User\UserId();
        $users->withId($this->userId)->willReturn($user);
        $user->demoteFromAdmin()->willReturn($user);
        $dispatcher->dispatchEventsFrom($user)->willReturn([]);

        $this->beConstructedWith($users, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DemoteUserFromAdminHandler::class);
    }

    function it_handles_demote_user_from_admin_command(
        EventDispatcher $dispatcher,
        User $user
    ) {
        $command = new DemoteUserFromAdminCommand($this->userId);
        $this->handle($command)->shouldBe($user);
        $user->demoteFromAdmin()->shouldHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($user)->shouldHaveBeenCalled();
    }
}