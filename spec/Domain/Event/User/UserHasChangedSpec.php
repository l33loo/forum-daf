<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Event\User;

use App\Domain\Event\User\UserHasChanged;
use App\Domain\User\Email;
use App\Domain\User\UserId;
use PhpSpec\ObjectBehavior;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * UserHasChangedSpec specs
 *
 * @package spec\App\Domain\Event\User
 */
class UserHasChangedSpec extends ObjectBehavior
{
    private $userId;
    private $name;
    private $email;

    function let()
    {
        $this->userId = new UserId();
        $this->name = "John Doe";
        $this->email = new Email("john@doe.com");
        $this->beConstructedWith($this->userId, $this->name, $this->email);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UserHasChanged::class);
    }

    function it_has_a_userId()
    {
        $this->userId()->shouldBe($this->userId);
    }

    function it_has_a_name()
    {
        $this->name()->shouldBe($this->name);
    }

    function it_has_a_email()
    {
        $this->email()->shouldBe($this->email);
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
            'name' => $this->name,
            'email' => $this->email
        ]);
    }
}