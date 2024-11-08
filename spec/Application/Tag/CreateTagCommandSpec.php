<?php

namespace spec\App\Application\Tag;

use App\Application\Tag\CreateTagCommand;
use PhpSpec\ObjectBehavior;

class CreateTagCommandSpec extends ObjectBehavior
{
    private $tag;

    function let()
    {
        $this->tag = "aTag";
        $this->beConstructedWith($this->tag);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CreateTagCommand::class);
    }

    function it_has_a_tag()
    {
        $this->tag()->shouldBe($this->tag);
    }
}