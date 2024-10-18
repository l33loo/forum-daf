<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\User;

use App\Application\User\SendPasswordResetEmailCommand;
use App\Application\User\SendPasswordResetEmailHandler;
use App\Domain\Common\EmailMessage;
use App\Domain\Common\EmailMessage\EmailContentCreator;
use App\Domain\Common\EmailMessage\EmailSender;
use App\Domain\Common\EmailMessage\MessageContent;
use App\Domain\Event\User\ResetPasswordEmailWasSent;
use App\Domain\User;
use App\Domain\User\UserId;
use App\Domain\User\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slick\Event\EventDispatcher;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * SendPasswordResetEmailHandlerSpec specs
 *
 * @package spec\App\Application\User
 */
class SendPasswordResetEmailHandlerSpec extends ObjectBehavior
{

    private $userId;
    private $token;

    function let(
        UserRepository $users,
        EmailContentCreator $contentCreator,
        TranslatorInterface $translator,
        EmailSender $emailSender,
        EventDispatcher $dispatcher,
        User $user
    ) {
        $this->userId = new UserId();
        $this->token = "some token";
        $users->withId($this->userId)->willReturn($user);
        $user->userId()->willReturn($this->userId);

        $translator->trans(Argument::type('string'))->willReturn("subject");

        $contentCreator->createContentFor(
            User\Email\ResetPasswordMessage::class,
            [
                'user' => $user,
                'subject' => "subject",
                'token' => $this->token
            ]
        )->willReturn(new MessageContent('test'));

        $emailSender->sendEmail(Argument::type(User\Email\ResetPasswordMessage::class))->willReturnArgument();

        $dispatcher->dispatch(Argument::type(ResetPasswordEmailWasSent::class))->willReturnArgument();

        $this->beConstructedWith($users, $contentCreator, $translator, $emailSender, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SendPasswordResetEmailHandler::class);
    }

    function it_handles_send_reset_password_email(
        EmailSender $emailSender,
        EventDispatcher $dispatcher
    ) {
         $command = new SendPasswordResetEmailCommand($this->userId, $this->token);
         $message = $this->handle($command);
         $message->shouldBeAnInstanceOf(User\Email\ResetPasswordMessage::class);
         $emailSender->sendEmail($message)->shouldHaveBeenCalled();
         $dispatcher->dispatch(Argument::type(ResetPasswordEmailWasSent::class))->shouldHaveBeenCalled();
    }
}