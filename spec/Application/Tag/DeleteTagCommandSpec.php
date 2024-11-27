<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Tag;

use App\Application\Tag\DeleteTagCommand;
use App\Domain\Tag\TagId;
use PhpSpec\ObjectBehavior;

/**
 * DeleteTagCommandSpec specs
 *
 * @package spec\App\Application\Tag
 */
class DeleteTagCommandSpec extends ObjectBehavior
{
    private $tagId;

    function let()
    {
        $this->tagId = new TagId();
        $this->beConstructedWith($this->tagId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DeleteTagCommand::class);
    }

    function it_has_a_tagId()
    {
        $this->tagId()->shouldBe($this->tagId);
    }
}