<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Event\User;

use App\Domain\Event\User\UserHasLoggedIn;
use App\Domain\User\UserId;
use DateTimeImmutable;
use PhpSpec\ObjectBehavior;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * UserHasLoggedInSpec specs
 *
 * @package spec\App\Domain\Event\User
 */
class UserHasLoggedInSpec extends ObjectBehavior
{

    private $userIdentifier;

    function let()
    {
        $this->userIdentifier = new UserId();
        $this->beConstructedWith($this->userIdentifier);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UserHasLoggedIn::class);
    }

    function it_has_a_user_identifier()
    {
        $this->userIdentifier()->shouldBe($this->userIdentifier);
    }


    function it_can_be_converted_to_json()
    {
        $this->shouldBeAnInstanceOf(\JsonSerializable::class);
        $this->jsonSerialize()->shouldBe([
            'userIdentifier' => $this->userIdentifier,
        ]);
    }

    function its_an_event()
    {
        $this->shouldBeAnInstanceOf(Event::class);
        $this->shouldHaveType(AbstractEvent::class);
        $this->occurredOn()->shouldBeAnInstanceOf(DateTimeImmutable::class);
    }
}