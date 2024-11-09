<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Tag;

use App\Domain\Tag\TagId;
use App\Application\Tag\VerifyTagCommand;
use PhpSpec\ObjectBehavior;

class VerifyTagCommandSpec extends ObjectBehavior
{
    private $tagId;

    function let()
    {
        $this->tagId = new TagId();
        $this->beConstructedWith($this->tagId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(VerifyTagCommand::class);
    }

    function it_has_a_tag_id()
    {
        $this->tagId()->shouldBe($this->tagId);
    }
}