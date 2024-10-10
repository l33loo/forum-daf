<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Event\User;

use App\Domain\Event\User\UserWasCreated;
use App\Domain\User\Email;
use App\Domain\User\UserId;
use DateTimeImmutable;
use PhpSpec\ObjectBehavior;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * UserWasCreatedSpec specs
 *
 * @package spec\App\Domain\Event\User
 */
class UserWasCreatedSpec extends ObjectBehavior
{

    private $userId;
    private $email;
    private $name;

    function let()
    {
        $this->userId = new UserId();
        $this->email = new Email('example@example.com');
        $this->name = 'John Doe';
        $this->beConstructedWith($this->userId, $this->email, $this->name);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UserWasCreated::class);
    }

    function it_has_a_user_id()
    {
        $this->userId()->shouldBe($this->userId);
    }

    function it_has_a_email()
    {
        $this->email()->shouldBe($this->email);
    }

    function it_has_a_name()
    {
        $this->name()->shouldBe($this->name);
    }

    function it_can_be_created_without_name()
    {
        $this->beConstructedWith($this->userId, $this->email);
        $this->name()->shouldBeNull();
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
            'email' => $this->email,
            'name' => $this->name,
        ]);
    }
}