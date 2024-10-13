<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Event\User;

use App\Domain\Event\User\UserHasRegistered;
use App\Domain\User\Email;
use App\Domain\User\UserId;
use DateTimeImmutable;
use JsonSerializable;
use PhpSpec\ObjectBehavior;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * UserHasRegisteredSpec specs
 *
 * @package spec\App\Domain\Event\User
 */
class UserHasRegisteredSpec extends ObjectBehavior
{

    private $userIdentifier;
    private $email;
    private $name;
    private $hashedPassword;

    function let()
    {
        $this->userIdentifier = new UserId();
        $this->email = new Email('john.doe@example.com');
        $this->name = 'John Doe';
        $this->hashedPassword = 'hashed_password';

        $this->beConstructedWith($this->userIdentifier, $this->email, $this->name, $this->hashedPassword);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UserHasRegistered::class);
    }

    function it_has_a_user_identifier()
    {
        $this->userIdentifier()->shouldBe($this->userIdentifier);
    }

    function it_has_a_email()
    {
        $this->email()->shouldBe($this->email);
    }

    function it_has_a_name()
    {
        $this->name()->shouldBe($this->name);
    }

    function it_has_a_hashed_password()
    {
        $this->hashedPassword()->shouldBe($this->hashedPassword);
    }

    function its_an_event()
    {
        $this->shouldBeAnInstanceOf(Event::class);
        $this->shouldHaveType(AbstractEvent::class);
        $this->occurredOn()->shouldBeAnInstanceOf(DateTimeImmutable::class);
    }

    function it_can_be_converted_to_json()
    {
        $this->shouldBeAnInstanceOf(JsonSerializable::class);
        $this->jsonSerialize()->shouldBe([
            'userIdentifier' => $this->userIdentifier,
            'email' => $this->email,
            'name' => $this->name,
            'hashedPassword' => $this->hashedPassword
        ]);
    }

    function it_can_be_created_without_name_and_hashed_password()
    {
        $this->beConstructedWith($this->userIdentifier, $this->email);
        $this->name()->shouldBeNull();
        $this->hashedPassword()->shouldBeNull();
    }

}