<?php
namespace spec\App\Application\Tag;

use App\Application\Tag\CreateTagHandler;
use App\Domain\Tag;
use App\Domain\Tag\TagRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slick\Event\EventDispatcher;

class CreateTagHandlerSpec extends ObjectBehavior
{
    function let(
        TagRepository $tags,
        EventDispatcher $dispatcher,
        Tag $tag
    )
    {
        $tags->add(Argument::type(Tag::class))->willReturnArgument();
        $dispatcher->dispatchEventsFrom(Argument::type(Tag::class))->willReturn([]);
        $this->beConstructedWith($tags, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CreateTagHandler::class);
    }
}