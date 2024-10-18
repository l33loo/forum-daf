<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\User;

use App\Application\User\UpdateUserCommand;
use App\Application\User\UpdateUserHandler;
use App\Domain\User;
use App\Domain\User\UserId;
use App\Domain\User\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slick\Event\EventDispatcher;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * UpdateUserHandlerSpec specs
 *
 * @package spec\App\Application\User
 */
class UpdateUserHandlerSpec extends ObjectBehavior
{
    private $userId;
    private $name;
    private $updatedEmail;

    function let(
        UserRepository $users,
        EventDispatcher $dispatcher,
        User\Specification\EmailNotUsedByAnotherUserSpecification $notInUse,
        User $user
    ) {
        $this->userId = new UserId();
        $users->withId($this->userId)->willReturn($user);
        $this->name = "New Name";
        $this->updatedEmail = new User\Email("john@doe.com");
        $user->update($this->name, $this->updatedEmail)->willReturn($user);
        $dispatcher->dispatchEventsFrom($user)->willReturn([]);

        $notInUse->isSatisfiedBy($user)->willReturn(true);

        $this->beConstructedWith($users, $notInUse, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UpdateUserHandler::class);
    }

    function it_handler_update_user_command(
        EventDispatcher $dispatcher,
        User $user
    ) {
        $command = new UpdateUserCommand($this->userId, $this->name, $this->updatedEmail);
        $this->handle($command)->shouldBe($user);
        $user->update($this->name, $this->updatedEmail)->shouldHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($user)->shouldHaveBeenCalled();
    }
}