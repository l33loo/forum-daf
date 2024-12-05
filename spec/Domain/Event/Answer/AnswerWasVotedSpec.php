<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Event\Answer;

use App\Domain\Event\Answer\AnswerWasChanged;
use App\Domain\Answer\AnswerId;
use App\Domain\User\UserId;
use PhpSpec\ObjectBehavior;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * AnswerWasChangedSpec specs
 *
 * @package spec\App\Domain\Event\Answer
 */
class AnswerWasChangedSpec extends ObjectBehavior
{
    private $answerId;
    private $userId;
    private $intention;

    function let()
    {
        $this->answerId = new AnswerId();
        $this->userId = new UserId();
        $this->intention = true;
        $this->beConstructedWith($this->answerId, $this->userId, $this->intention);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AnswerWasVoted::class);
    }

    function it_has_an_answerId()
    {
        $this->answerId()->shouldBe($this->answerId);
    }

    function it_has_a_userId()
    {
        $this->userId()->shouldBe($this->userId);
    }

    function it_has_an_intention()
    {
        $this->intention()->shouldBe($this->intention);
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
            'answerId' => $this->answerId,
            'userId' => $this->userId,
            'intention' => $this->intention,
        ]);
    }
}