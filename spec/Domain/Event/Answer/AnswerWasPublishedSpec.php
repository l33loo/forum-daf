<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Event\Answer;

use App\Domain\Event\Answer\AnswerWasPublished;
use App\Domain\Answer\AnswerId;
use DateTimeImmutable;
use PhpSpec\ObjectBehavior;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * AnswerWasPublishedSpec specs
 *
 * @package spec\App\Domain\Event\Answer
 */
class AnswerWasPublishedSpec extends ObjectBehavior
{

    private $answerId;
    private $publishedOn;

    function let()
    {
        $this->answerId = new AnswerId();
        $this->publishedOn = new DateTimeImmutable();
        $this->beConstructedWith($this->answerId, $this->publishedOn);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AnswerWasPublished::class);
    }

    function it_has_a_answerId()
    {
        $this->answerId()->shouldBe($this->answerId);
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
            'answerId' => $this->answerId,
            'publishedOn' => $this->publishedOn,
        ]);
    }
}