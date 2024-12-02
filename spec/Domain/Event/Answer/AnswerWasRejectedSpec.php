<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Event\Answer;

use App\Domain\Event\Answer\AnswerWasRejected;
use App\Domain\Answer\AnswerId;
use PhpSpec\ObjectBehavior;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * AnswerWasRejectedSpec specs
 *
 * @package spec\App\Domain\Event\Answer
 */
class AnswerWasRejectedSpec extends ObjectBehavior
{

    private $answerId;
    private $rejectReason;

    function let()
    {
        $this->answerId = new AnswerId();
        $this->rejectReason = 'Invalid subject';
        $this->beConstructedWith($this->answerId, $this->rejectReason);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AnswerWasRejected::class);
    }

    function it_has_a_answerId()
    {
        $this->answerId()->shouldBe($this->answerId);
    }

    function it_has_a_rejectReason()
    {
        $this->rejectReason()->shouldBe($this->rejectReason);
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
        $this->jsonSerialize()->shouldBeLike([
            'answerId' => $this->answerId,
            'rejectReason' => $this->rejectReason,
        ]);
    }
}