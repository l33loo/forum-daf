<?php
namespace spec\App\Domain\Event\Tag;

use App\Domain\Event\Tag\TagWasCreated;
use App\Domain\Tag\TagId;
use DateTimeImmutable;
use JsonSerializable;
use PhpSpec\ObjectBehavior;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

class TagWasCreatedSpec extends ObjectBehavior
{
    private $tagId;
    private $tag;

    function let()
    {
        $this->tagId = new TagId();
        $this->tag = "Tagname";
        $this->beConstructedWith($this->tagId, $this->tag);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(TagWasCreated::class);
    }

    function it_had_a_tagId()
    {
        $this->tagId()->shouldBe($this->tagId);
    }

    function it_has_a_tag()
    {
        $this->tag()->shouldBe($this->tag);
    }

    function it_is_an_event()
    {
        $this->shouldBeAnInstanceOf(Event::class);
        $this->shouldHaveType(AbstractEvent::class);
        $this->occurredOn()->shouldBeAnInstanceOf(DateTimeImmutable::class);
    }

    function it_can_be_converted_to_json()
    {
        $this->shouldBeAnInstanceOf(JsonSerializable::class);
        $this->jsonSerialize()->shouldBe([
            'tagId' => $this->tagId,
            'tag' => $this->tag,
        ]);
    }
}