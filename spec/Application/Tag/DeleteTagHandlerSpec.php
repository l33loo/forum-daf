<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Tag;

use App\Application\Tag\DeleteTagCommand;
use App\Application\Tag\DeleteTagHandler;
use App\Domain\Tag;
use App\Domain\Tag\TagId;
use App\Domain\Tag\TagRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slick\Event\EventDispatcher;

/**
 * DeleteTagHandlerSpec specs
 *
 * @package spec\App\Application\Tag
 */
class DeleteTagHandlerSpec extends ObjectBehavior
{
    private $tagId;

    function let(
        TagRepository $tags,
        EventDispatcher $dispatcher,
        Tag $tag
    ) {
        $this->tagId = new TagId();
        $tags->withId($this->tagId)->willReturn($tag);
        $tag->remove()->willReturn($tag);
        $dispatcher->dispatchEventsFrom($tag)->willReturn([]);
        $this->beConstructedWith($tags, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DeleteTagHandler::class);
    }

    function it_handles_delete_tag_command(
        EventDispatcher $dispatcher,
        Tag $tag
    ) {
        $command = new DeleteTagCommand($this->tagId);
        $this->handle($command)->shouldBe($tag);
        $dispatcher->dispatchEventsFrom($tag)->shouldHaveBeenCalled();
    }
}