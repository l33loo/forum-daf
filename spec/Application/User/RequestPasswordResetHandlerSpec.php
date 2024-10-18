<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\User;

use App\Application\User\RequestPasswordResetCommand;
use App\Application\User\RequestPasswordResetHandler;
use App\Domain\Event\User\PasswordResetWasRequested;
use App\Domain\User;
use App\Domain\User\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slick\Event\EventDispatcher;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordToken;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

/**
 * RequestPasswordResetHandlerSpec specs
 *
 * @package spec\App\Application\User
 */
class RequestPasswordResetHandlerSpec extends ObjectBehavior
{

    private $token;
    private $email;

    function let(
        UserRepository $users,
        ResetPasswordHelperInterface $helper,
        EventDispatcher $dispatcher,
        User $user
    ) {
        $user->userId()->willReturn(new User\UserId());
        $this->email = new User\Email('john.doe@example.com');
        $users->withEmail($this->email)->willReturn($user);
        $this->token = new ResetPasswordToken('test', new \DateTimeImmutable());
        $helper->generateResetToken($user)->willReturn($this->token);

        $dispatcher->dispatch(Argument::type(PasswordResetWasRequested::class))->willReturnArgument();

        $this->beConstructedWith($users, $helper, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RequestPasswordResetHandler::class);
    }

    function it_handles_request_password_reset(User $user, EventDispatcher $dispatcher)
    {
        $command = new RequestPasswordResetCommand($this->email);
        $this->handle($command)->shouldBe($user);
        $dispatcher->dispatch(Argument::type(PasswordResetWasRequested::class))->shouldHaveBeenCalled();
    }
}