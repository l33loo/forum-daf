<?php

declare(strict_types=1);

namespace spec\App\Domain;

use App\Domain\Tag;
use App\Domain\Event\Tag\TagWasCreated;
use PhpSpec\ObjectBehavior;
use Slick\Event\EventGenerator;

class TagSpec extends ObjectBehavior
{
    private $tag;

    function let(): void
    {
        $this->tag = 'Sometag';
        $this->beConstructedWith($this->tag);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(Tag::class);
    }

    function it_has_a_tag(): void
    {
        $this->tag()->shouldBe($this->tag);
    }

    function its_an_event_generator()
    {
        $this->shouldBeAnInstanceOf(EventGenerator::class);
        $events = $this->releaseEvents();
        $events->shouldHaveCount(1);
        $events[0]->shouldBeAnInstanceOf(TagWasCreated::class);
    }
}