<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Event\User;

use App\Domain\Event\User\UserEmailWasConfirmed;
use App\Domain\User\Email;
use App\Domain\User\EmailConfirmationRequest;
use DateTimeImmutable;
use PhpSpec\ObjectBehavior;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * UserEmailWasConfirmedSpec specs
 *
 * @package spec\App\Domain\Event\User
 */
class UserEmailWasConfirmedSpec extends ObjectBehavior
{

    private $email;
    private $emailConfirmationId;

    function let()
    {
        $this->email = new Email('test@test.com');
        $this->emailConfirmationId = new EmailConfirmationRequest\EmailConfirmationRequestId();
        $this->beConstructedWith($this->email, $this->emailConfirmationId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UserEmailWasConfirmed::class);
    }

    function it_has_a_email()
    {
        $this->email()->shouldBe($this->email);
    }

    function it_has_a_emailConfirmationId()
    {
        $this->emailConfirmationId()->shouldBe($this->emailConfirmationId);
    }

    function its_an_event()
    {
        $this->shouldBeAnInstanceOf(Event::class);
        $this->shouldHaveType(AbstractEvent::class);
        $this->occurredOn()->shouldBeAnInstanceOf(DateTimeImmutable::class);
    }

    function it_can_be_converted_to_json()
    {
        $this->shouldBeAnInstanceOf(\JsonSerializable::class);
        $this->jsonSerialize()->shouldBe([
            'email' => $this->email,
            'emailConfirmationId' => $this->emailConfirmationId
        ]);
    }
}