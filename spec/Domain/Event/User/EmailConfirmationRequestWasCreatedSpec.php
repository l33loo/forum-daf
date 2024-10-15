<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Event\User;

use App\Domain\Event\User\EmailConfirmationRequestWasCreated;
use App\Domain\User\EmailConfirmationRequest\EmailConfirmationRequestId;
use App\Domain\User\UserId;
use DateTimeImmutable;
use PhpSpec\ObjectBehavior;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * EmailConfirmationRequestWasCreatedSpec specs
 *
 * @package spec\App\Domain\Event\User
 */
class EmailConfirmationRequestWasCreatedSpec extends ObjectBehavior
{
    private $userId;
    private $emailConfirmationRequestId;
    private $expireDate;

    function let()
    {
        $this->userId = new UserId();
        $this->emailConfirmationRequestId = new EmailConfirmationRequestId();
        $this->expireDate = new DateTimeImmutable();
        $this->beConstructedWith($this->userId, $this->emailConfirmationRequestId, $this->expireDate);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(EmailConfirmationRequestWasCreated::class);
    }

    function it_has_a_userId()
    {
        $this->userId()->shouldBe($this->userId);
    }

    function it_has_a_emailConfirmationRequestId()
    {
        $this->emailConfirmationRequestId()->shouldBe($this->emailConfirmationRequestId);
    }

    function it_has_a_expireDate()
    {
        $this->expireDate()->shouldBe($this->expireDate);
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
            'userId' => $this->userId,
            'emailConfirmationRequestId' => $this->emailConfirmationRequestId,
            'expireDate' => $this->expireDate,
        ]);
    }
}