<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Tag;

use App\Application\Tag\EditTagCommand;
use App\Domain\Tag\TagId;
use PhpSpec\ObjectBehavior;

/**
 * EditTagCommandSpec specs
 *
 * @package spec\App\Application\Tag
 */
class EditTagCommandSpec extends ObjectBehavior
{
    private $tagId;
    private $tag;

    function let()
    {
        $this->tagId = new TagId();
        $this->tag = "New";
        $this->beConstructedWith($this->tagId, $this->tag);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(EditTagCommand::class);
    }

    function it_has_a_tagId()
    {
        $this->tagId()->shouldBe($this->tagId);
    }

    function it_has_a_tag()
    {
        $this->tag()->shouldBe($this->tag);
    }
}