<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Tag;

use App\Application\Tag\VerifyTagCommand;
use App\Domain\Tag;
use PhpSpec\ObjectBehavior;

class VerifyTagCommandSpec extends ObjectBehavior
{
    private $tag;

    function let()
    {
        $this->tag = new Tag("hello");
        $this->beConstructedWith($this->tag);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(VerifyTagCommand::class);
    }

    function it_has_a_tag()
    {
        $this->tag()->shouldBe($this->tag);
    }
}