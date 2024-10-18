<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Event\User;

use App\Domain\Event\User\UserEmailHasChanged;
use App\Domain\User\Email;
use App\Domain\User\UserId;
use PhpSpec\ObjectBehavior;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * UserEmailHasChangedSpec specs
 *
 * @package spec\App\Domain\Event\User
 */
class UserEmailHasChangedSpec extends ObjectBehavior
{

    private $userId;
    private $oldEmail;
    private $updatedEmail;

    function let()
    {
        $this->userId = new UserId();
        $this->oldEmail = new Email("john@doe.com");
        $this->updatedEmail = new Email("john@doe.org");

        $this->beConstructedWith($this->userId, $this->oldEmail, $this->updatedEmail);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UserEmailHasChanged::class);
    }

    function it_has_a_userId()
    {
        $this->userId()->shouldBe($this->userId);
    }

    function it_has_a_oldEmail()
    {
        $this->oldEmail()->shouldBe($this->oldEmail);
    }

    function it_has_a_updatedEmail()
    {
        $this->updatedEmail()->shouldBe($this->updatedEmail);
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
            'oldEmail' => $this->oldEmail,
            'updatedEmail' => $this->updatedEmail,
            'userId' => $this->userId
        ]);
    }
}