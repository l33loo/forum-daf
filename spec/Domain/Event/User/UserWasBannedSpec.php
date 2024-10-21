<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Event\User;

use App\Domain\Event\User\UserWasBanned;
use App\Domain\User\UserId;
use PhpSpec\ObjectBehavior;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * UserWasBannedSpec specs
 *
 * @package spec\App\Domain\Event\User
 */
class UserWasBannedSpec extends ObjectBehavior
{

    private $userId;
    private $reason;

    function let()
    {
        $this->userId = new UserId();
        $this->reason = "Some reason";
        $this->beConstructedWith($this->userId, $this->reason);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UserWasBanned::class);
    }

    function it_has_a_userId()
    {
        $this->userId()->shouldBe($this->userId);
    }

    function it_has_a_reason()
    {
        $this->reason()->shouldBe($this->reason);
    }

    function its_an_event()
    {
        $this->shouldBeAnInstanceOf(Event::class);
        $this->shouldHaveType(AbstractEvent::class);
        $this->occurredOn()->shouldBeAnInstanceOf(\DateTimeImmutable::class);
    }

    function it_can_be_converted_to_json()
    {
        $this->shouldBeAnInstanceOf(\JsonSerializable::class);
        $this->jsonSerialize()->shouldBe([
            'userId' => $this->userId,
            'reason' => $this->reason,
        ]);
    }
}