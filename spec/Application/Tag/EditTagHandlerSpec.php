<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Tag;

use App\Application\Tag\EditTagCommand;
use App\Application\Tag\EditTagHandler;
use App\Domain\Tag;
use App\Domain\Tag\TagRepository;
use PhpSpec\ObjectBehavior;
use Slick\Event\EventDispatcher;

/**
 * EditTagHandlerSpec specs
 *
 * @package spec\App\Application\Tag
 */
class EditTagHandlerSpec extends ObjectBehavior
{
    private Tag $tag;

    function let(
        TagRepository $tags,
        EventDispatcher $dispatcher,
    ) {
        $this->tag = new Tag('foo');
        $tags->withId($this->tag->tagId())->willReturn($this->tag);
        $dispatcher->dispatchEventsFrom($this->tag)->willReturn([]);

        $this->beConstructedWith($tags, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(EditTagHandler::class);
    }

    function it_handles_edit_tag_command(
        EventDispatcher $dispatcher
    ) {
        $command = new EditTagCommand($this->tag->tagId(), 'bar');
        $this->handle($command)->shouldBe($this->tag);
        $dispatcher->dispatchEventsFrom($this->tag)->shouldHaveBeenCalled();
    }
}