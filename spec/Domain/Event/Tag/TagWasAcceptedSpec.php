<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Event\Tag;

use App\Domain\Event\Tag\TagWasAccepted;
use App\Domain\Tag\TagId;
use PhpSpec\ObjectBehavior;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * TagWasAcceptedSpec specs
 *
 * @package spec\App\Domain\Event\Tag
 */
class TagWasAcceptedSpec extends ObjectBehavior
{
    private $tagId;

    function let()
    {
        $this->tagId = new TagId();
        $this->beConstructedWith($this->tagId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(TagWasAccepted::class);
    }

    function it_has_a_tagId()
    {
        $this->tagId()->shouldBe($this->tagId);
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
            'tagId' => $this->tagId
        ]);
    }
}