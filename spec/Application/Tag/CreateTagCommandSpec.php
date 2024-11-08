<?php

namespace spec\App\Application\Tag;

use App\Application\Tag\CreateTagCommand;
use PhpSpec\ObjectBehavior;

class CreateTagCommandSpec extends ObjectBehavior
{
    private $name;

    function let()
    {
        $this->name = "Tagname";
        $this->beConstructedWith($this->name);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CreateTagCommand::class);
    }

    function it_has_a_name()
    {
        $this->name()->shouldBe($this->name);
    }
}