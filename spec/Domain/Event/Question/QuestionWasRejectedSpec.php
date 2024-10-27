<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Event\Question;

use App\Domain\Event\Question\QuestionWasRejected;
use App\Domain\Question\QuestionId;
use App\Domain\User\UserId;
use PhpSpec\ObjectBehavior;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * QuestionWasRejectedSpec specs
 *
 * @package spec\App\Domain\Event\Question
 */
class QuestionWasRejectedSpec extends ObjectBehavior
{

    private $questionId;
    private $rejectReason;

    function let()
    {
        $this->questionId = new QuestionId();
        $this->rejectReason = 'Invalid subject';
        $this->beConstructedWith($this->questionId, $this->rejectReason);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(QuestionWasRejected::class);
    }

    function it_has_a_questionId()
    {
        $this->questionId()->shouldBe($this->questionId);
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
            'questionId' => $this->questionId,
            'rejectReason' => $this->rejectReason,
        ]);
    }
}