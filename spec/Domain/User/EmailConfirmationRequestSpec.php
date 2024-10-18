<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\User;

use App\Domain\User;
use App\Domain\User\EmailConfirmationRequest;
use App\Domain\User\EmailConfirmationRequest\EmailConfirmationRequestId;
use DateInterval;
use DateTimeImmutable;
use PhpSpec\ObjectBehavior;
use Stringable;

/**
 * EmailConfirmationRequestSpec specs
 *
 * @package spec\App\Domain\User
 */
class EmailConfirmationRequestSpec extends ObjectBehavior
{

    private $validityPeriod;
    private $email;

    function let(User $user)
    {
        $this->email = new User\Email('foo@bar.com');
        $user->email()->willReturn($this->email);
        $this->validityPeriod = 'PT24H';
        $this->beConstructedWith($user, $this->validityPeriod);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(EmailConfirmationRequest::class);
    }

    function it_has_an_email_confirmation_request_id()
    {
        $this->emailConfirmationRequestId()->shouldBeAnInstanceOf(EmailConfirmationRequestId::class);
    }

    function it_has_a_user(User $user)
    {
        $this->user()->shouldBe($user);
    }

    function it_has_an_email()
    {
        $this->email()->shouldBe($this->email);
    }


    function it_has_an_expired_date()
    {
        $date = $this->expireDate();
        $date->shouldBeAnInstanceOf(DateTimeImmutable::class);
        $date->format("Y-m-d")->shouldBe((new DateTimeImmutable())->add(new DateInterval($this->validityPeriod))->format("Y-m-d"));
    }

    function it_can_check_its_validity()
    {
        $this->isValid()->shouldBe(true);
    }

    function it_has_a_verified_check()
    {
        $this->isVerified()->shouldBe(false);
    }

    function it_can_be_verified()
    {
        $this->verify()->shouldBe($this->getWrappedObject());
        $this->isVerified()->shouldBe(true);
    }

    function it_can_be_converted_to_string()
    {
        $this->shouldBeAnInstanceOf(Stringable::class);
        $this->__toString()->shouldBe((string) $this->emailConfirmationRequestId()->getWrappedObject());
    }
}