<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\User\Email;

use App\Domain\Common\EmailMessage;
use App\Domain\Common\EmailMessage\MessageId;
use App\Domain\User;
use App\Domain\User\Email\EmailConfirmationMessage;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * EmailConfirmationMessageSpec specs
 *
 * @package spec\App\Domain\User\Email
 */
class EmailConfirmationMessageSpec extends ObjectBehavior
{

    private $subject;
    private $message;

    function let(User $user, User\EmailConfirmationRequest $request)
    {
        $this->subject = 'subject';
        $this->message = new EmailMessage\MessageContent('Some mail message');

        $user->createEmailConfirmation(Argument::type("string"))->willReturn($request);

        $this->beConstructedWith($user, $this->subject, $this->message);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(EmailConfirmationMessage::class);
    }

    function it_has_a_user(User $user)
    {
        $this->user()->shouldBe($user);
    }

    function it_has_a_subject()
    {
        $this->subject()->shouldBe($this->subject);
    }

    function it_has_a_message()
    {
        $this->message()->shouldBe($this->message);
    }

    function it_has_a_message_id()
    {
        $this->messageId()->shouldBeAnInstanceOf(MessageId::class);
    }

    function its_an_email_message(User $user)
    {
        $this->shouldBeAnInstanceOf(EmailMessage::class);
        $this->recipients()->shouldBe([$user]);
    }

    function it_provides_context_data_to_email_template_rendering(User $user, User\EmailConfirmationRequest $request)
    {
        $this->context()->shouldReturn([
            'subject' => $this->subject,
            'user' => $user,
            'token' => $request
        ]);
    }

}