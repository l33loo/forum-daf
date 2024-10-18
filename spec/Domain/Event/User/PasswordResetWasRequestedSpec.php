<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Event\User;

use App\Domain\Event\User\PasswordResetWasRequested;
use App\Domain\User\UserId;
use DateTimeImmutable;
use PhpSpec\ObjectBehavior;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * PasswordResetWasRequestedSpec specs
 *
 * @package spec\App\Domain\Event\User
 */
class PasswordResetWasRequestedSpec extends ObjectBehavior
{

    private $token;
    private $userId;

    function let()
    {
        $this->token = "test-token";
        $this->userId = new UserId();
        $this->beConstructedWith($this->userId, $this->token);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PasswordResetWasRequested::class);
    }

    function it_has_a_userId()
    {
        $this->userId()->shouldBe($this->userId);
    }

    function it_has_a_token()
    {
        $this->token()->shouldBe($this->token);
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
            'token' => $this->token,
            'userId' => $this->userId
        ]);
    }
}