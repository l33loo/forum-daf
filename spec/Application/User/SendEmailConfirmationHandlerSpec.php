<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\User;

use App\Application\User\SendEmailConfirmationCommand;
use App\Application\User\SendEmailConfirmationHandler;
use App\Domain\Common\EmailMessage\EmailContentCreator;
use App\Domain\Common\EmailMessage\EmailSender;
use App\Domain\Common\EmailMessage\MessageContent;
use App\Domain\Event\User\EmailConfirmationWasSent;
use App\Domain\User;
use App\Domain\User\Email\EmailConfirmationMessage;
use App\Domain\User\UserId;
use App\Domain\User\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slick\Event\EventDispatcher;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * SendEmailConfirmationHandlerSpec specs
 *
 * @package spec\App\Application\User
 */
class SendEmailConfirmationHandlerSpec extends ObjectBehavior
{

    private $userId;

    function let(
        UserRepository $users,
        EmailContentCreator $contentCreator,
        EmailSender $emailSender,
        EventDispatcher $dispatcher,
        TranslatorInterface $translator,
        User $user
    ) {

        $this->userId = new UserId();
        $users->withId($this->userId)->willReturn($user);
        $contentCreator->createContentFor(EmailConfirmationMessage::class, Argument::type("array"))->willReturn(new MessageContent('test'));
        $emailSender->sendEmail(Argument::type(EmailConfirmationMessage::class))->willReturnArgument();
        $dispatcher->dispatch(Argument::type(EmailConfirmationWasSent::class))->willReturnArgument();
        $dispatcher->dispatchEventsFrom($user)->willReturn([]);

        $translator->trans(Argument::type('string'))->willReturnArgument();

        $this->beConstructedWith($users, $contentCreator, $translator, $emailSender, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SendEmailConfirmationHandler::class);
    }

    function it_handles_send_confirmation_email_command(User $user, EmailSender $emailSender, EventDispatcher $dispatcher)
    {
        $command = new SendEmailConfirmationCommand($this->userId);
        $message = $this->handle($command);
        $message->shouldBeAnInstanceOf(EmailConfirmationMessage::class);
        $emailSender->sendEmail($message)->shouldHaveBeenCalled();
        $dispatcher->dispatch(Argument::type(EmailConfirmationWasSent::class))->shouldHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($user)->shouldHaveBeenCalled();
    }
}