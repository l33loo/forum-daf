<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Event\User;

use App\Domain\Event\User\UserAccountWasRemoved;
use App\Domain\User\UserId;
use PhpSpec\ObjectBehavior;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * UserAccountWasRemovedSpec specs
 *
 * @package spec\App\Domain\Event\User
 */
class UserAccountWasRemovedSpec extends ObjectBehavior
{

    private $userId;

    function let()
    {
        $this->userId = new UserId();
        $this->beConstructedWith($this->userId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UserAccountWasRemoved::class);
    }

    function it_has_a_userId()
    {
        $this->userId()->shouldBe($this->userId);
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
        ]);
    }
}