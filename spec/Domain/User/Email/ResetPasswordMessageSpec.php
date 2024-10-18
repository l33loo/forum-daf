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
use App\Domain\User\Email\ResetPasswordMessage;
use PhpSpec\ObjectBehavior;

/**
 * ResetPasswordMessageSpec specs
 *
 * @package spec\App\Domain\User\Email
 */
class ResetPasswordMessageSpec extends ObjectBehavior
{

    private $token;
    private $subject;
    private $message;

    function let(User $user)
    {
        $this->token = "token";
        $this->subject = "subject";
        $this->message = new EmailMessage\MessageContent('Some mail message');

        $this->beConstructedWith($user, $this->token, $this->subject, $this->message);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ResetPasswordMessage::class);
    }

    function its_an_email_message(User $user)
    {
        $this->shouldBeAnInstanceOf(EmailMessage::class);
        $this->recipients()->shouldBe([$user]);
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

    function it_provides_context_data_to_email_template_rendering(User $user)
    {
        $this->context()->shouldReturn([
            'subject' => $this->subject,
            'user' => $user,
            'token' => $this->token
        ]);
    }
}