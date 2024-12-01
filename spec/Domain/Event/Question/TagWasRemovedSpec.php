<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Event\Question;

use App\Domain\Event\Question\TagWasRemoved;
use App\Domain\Question\QuestionId;
use App\Domain\Tag;
use PhpSpec\ObjectBehavior;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * TagWasRemovedSpec specs
 *
 * @package spec\App\Domain\Event\Question
 */
class TagWasRemovedSpec extends ObjectBehavior
{
    private $questionId;
    private $tag;

    function let()
    {
        $this->questionId = new QuestionId();
        $this->tag = new Tag('hello');
        $this->beConstructedWith($this->questionId, $this->tag);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(TagWasRemoved::class);
    }

    function it_has_a_questionId()
    {
        $this->questionId()->shouldBe($this->questionId);
    }

    function it_has_a_tag()
    {
        $this->tag()->shouldBe($this->tag);
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
            'questionId' => $this->questionId,
            'tag' => [
                'tagId' => $this->tag->tagId(),
                'tag' => $this->tag->tag(),
            ],
        ]);
    }
}