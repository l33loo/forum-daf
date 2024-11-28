<?php
namespace spec\App\Domain\Event\Tag;

use App\Domain\Event\Tag\TagWasEdited;
use App\Domain\Tag\TagId;
use JsonSerializable;
use PhpSpec\ObjectBehavior;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

class TagWasEditedSpec extends ObjectBehavior
{
    private $tagId;
    private $newTag;

    function let()
    {
        $this->tagId = new TagId();
        $this->newTag = 'bar';
        $this->beConstructedWith($this->tagId, $this->newTag);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(TagWasEdited::class);
    }

    function it_has_a_tagId()
    {
        $this->tagId()->shouldBe($this->tagId);
    }

    function it_has_a_new_tag()
    {
        $this->newTag()->shouldBe($this->newTag);
    }

    function it_is_an_event()
    {
        $this->shouldBeAnInstanceOf(Event::class);
        $this->shouldHaveType(AbstractEvent::class);
    }

    function it_can_be_converted_to_json()
    {
        $this->shouldBeAnInstanceOf(JsonSerializable::class);
        $this->jsonSerialize()->shouldBe([
            'tagId' => $this->tagId,
            'newTag' => $this->newTag
        ]);
    }
}