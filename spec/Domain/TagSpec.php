<?php

declare(strict_types=1);

namespace spec\App\Domain;

use App\Domain\Tag;

use PhpSpec\ObjectBehavior;
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
}