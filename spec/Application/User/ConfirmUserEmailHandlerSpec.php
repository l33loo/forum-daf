<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\User;

use App\Application\User\ConfirmUserEmailCommand;
use App\Application\User\ConfirmUserEmailHandler;
use App\Domain\Exception\FailedSpecification;
use App\Domain\User;
use App\Domain\User\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slick\Event\EventDispatcher;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * ConfirmUserEmailHandlerSpec specs
 *
 * @package spec\App\Application\User
 */
class ConfirmUserEmailHandlerSpec extends ObjectBehavior
{
    private $token;

    function let(
        UserRepository $users,
        User\Specification\CanVerifyEmailSpecification $canVerifyEmailSpec,
        EventDispatcher $eventDispatcher,
        User $user,
        User\EmailConfirmationRequest $request,
        TranslatorInterface $translator
    ) {
        $users->currentLoggedInUser()->willReturn($user);
        $this->token = "token";
        $users->emailConfirmationToken($this->token)->willReturn($request);

        $canVerifyEmailSpec->isSatisfiedBy($request)->willReturn(true);

        $user->confirmEmail($request)->willReturn($user);

        $eventDispatcher->dispatchEventsFrom($user)->willReturn([]);
        $translator->trans(Argument::type('string'))->willReturnArgument();

        $this->beConstructedWith($users, $canVerifyEmailSpec, $translator, $eventDispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ConfirmUserEmailHandler::class);
    }

    function it_handles_confirm_user_email_command(
        User $user,
        User\EmailConfirmationRequest $request,
        EventDispatcher $eventDispatcher
    ) {
        $command = new ConfirmUserEmailCommand($this->token);
        $this->handle($command)->shouldBe($user);
        $user->confirmEmail($request)->shouldHaveBeenCalled();
        $eventDispatcher->dispatchEventsFrom($user)->shouldHaveBeenCalled();
    }

    function it_throws_exception_when_can_confirm_specification_fails(
        User\Specification\CanVerifyEmailSpecification $canVerifyEmailSpec,
        User\EmailConfirmationRequest $request,
    ) {
        $command = new ConfirmUserEmailCommand($this->token);
        $canVerifyEmailSpec->isSatisfiedBy($request)->willReturn(false);
        $this->shouldThrow(FailedSpecification::class)
            ->during('handle', [$command]);
    }
}