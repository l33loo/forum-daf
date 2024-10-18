<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Event\User;

use App\Domain\Common\EmailMessage\MessageContent;
use App\Domain\Common\EmailMessage\MessageId;
use App\Domain\Event\User\ResetPasswordEmailWasSent;
use App\Domain\User\UserId;
use DateTimeImmutable;
use PhpSpec\ObjectBehavior;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * ResetPasswordEmailWasSentSpec specs
 *
 * @package spec\App\Domain\Event\User
 */
class ResetPasswordEmailWasSentSpec extends ObjectBehavior
{

    private $userId;
    private $messageId;
    private $message;

    function let()
    {
        $this->userId = new UserId();
        $this->messageId = new MessageId();
        $this->message = new MessageContent('test');
        $this->beConstructedWith($this->userId, $this->messageId, $this->message);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ResetPasswordEmailWasSent::class);
    }

    function it_has_a_userId()
    {
        $this->userId()->shouldBe($this->userId);
    }

    function it_has_a_messageId()
    {
        $this->messageId()->shouldBe($this->messageId);
    }

    function it_has_a_message()
    {
        $this->message()->shouldBe($this->message);
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
            'messageId' => $this->messageId,
            'message' => $this->message,
        ]);
    }

}