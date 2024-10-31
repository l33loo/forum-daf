<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Event\Question;

use App\Domain\Event\Question\QuestionWasPublished;
use App\Domain\Question\QuestionId;
use DateTimeImmutable;
use PhpSpec\ObjectBehavior;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * QuestionWasPublishedSpec specs
 *
 * @package spec\App\Domain\Event\Question
 */
class QuestionWasPublishedSpec extends ObjectBehavior
{

    private $questionId;
    private $publishedOn;

    function let()
    {
        $this->questionId = new QuestionId();
        $this->publishedOn = new DateTimeImmutable();
        $this->beConstructedWith($this->questionId, $this->publishedOn);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(QuestionWasPublished::class);
    }

    function it_has_a_questionId()
    {
        $this->questionId()->shouldBe($this->questionId);
    }

    function it_has_a_publishedOn()
    {
        $this->publishedOn()->shouldBe($this->publishedOn);
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
            'questionId' => $this->questionId,
            'publishedOn' => $this->publishedOn,
        ]);
    }
}