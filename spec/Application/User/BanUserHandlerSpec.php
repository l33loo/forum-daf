<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\User;

use App\Application\User\BanUserCommand;
use App\Application\User\BanUserHandler;
use App\Domain\User;
use App\Domain\User\UserRepository;
use PhpSpec\ObjectBehavior;
use Slick\Event\EventDispatcher;

/**
 * BanUserHandlerSpec specs
 *
 * @package spec\App\Application\User
 */
class BanUserHandlerSpec extends ObjectBehavior
{

    private $userId;
    private $reason;

    function let(
        UserRepository $users,
        EventDispatcher $dispatcher,
        User $user
    ) {
        $this->userId = new User\UserId();
        $this->reason = 'Some reason';
        $users->withId($this->userId)->willReturn($user);
        $user->ban($this->reason)->willReturn($user);
        $dispatcher->dispatchEventsFrom($user)->willReturn([]);

        $this->beConstructedWith($users, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(BanUserHandler::class);
    }

    function it_handle_ban_user_command(
        EventDispatcher $dispatcher,
        User $user
    ) {
        $command = new BanUserCommand($this->userId, $this->reason);
        $this->handle($command)->shouldBe($user);
        $user->ban($this->reason)->shouldHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($user)->shouldHaveBeenCalled();
    }
}