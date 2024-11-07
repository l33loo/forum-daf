<?php

declare(strict_types=1);

namespace spec\App\Domain;

use App\Domain\Tag;

use PhpSpec\ObjectBehavior;
class TagSpec extends ObjectBehavior
{
    private $name;

    function let(): void
    {
        $this->name = 'Sometag';
        $this->beConstructedWith($this->name);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(Tag::class);
    }

    function it_has_a_name(): void
    {
        $this->name()->shouldBe($this->name);
    }
}