<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Event\User;

use App\Domain\Event\User\UserHasChangedPassword;
use App\Domain\User\UserId;
use PhpSpec\ObjectBehavior;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * UserHasChangedPasswordSpec specs
 *
 * @package spec\App\Domain\Event\User
 */
class UserHasChangedPasswordSpec extends ObjectBehavior
{

    private $userId;
    private $passwordHash;

    function let()
    {
        $this->userId = new UserId();
        $this->passwordHash = 'password';
        $this->beConstructedWith($this->userId, $this->passwordHash);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UserHasChangedPassword::class);
    }

    function it_has_a_userId()
    {
        $this->userId()->shouldBe($this->userId);
    }


    function it_has_a_passwordHash()
    {
        $this->passwordHash()->shouldBe($this->passwordHash);
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
            'passwordHash' => $this->passwordHash,
        ]);
    }
}