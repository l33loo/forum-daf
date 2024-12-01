<?php
namespace spec\App\Application\Tag;

use App\Application\Tag\CreateTagCommand;
use App\Application\Tag\CreateTagHandler;
use App\Domain\Tag;
use App\Domain\Tag\TagRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slick\Event\EventDispatcher;

class CreateTagHandlerSpec extends ObjectBehavior
{
    private $tag;
    function let(
        TagRepository $tags,
        EventDispatcher $dispatcher
    )
    {
        $this->tag = new Tag('foo');
        $tags->add(Argument::type(Tag::class))->willReturnArgument();
        $dispatcher->dispatchEventsFrom(Argument::type(Tag::class))->willReturn([]);
        $this->beConstructedWith($tags, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CreateTagHandler::class);
    }

    function it_handles_create_tag(
        TagRepository $tags,
        EventDispatcher $dispatcher,
    ) {
        $command = new CreateTagCommand($this->tag);
        $tag = $this->handle($command);
        $tag->shouldBe($this->tag);
        $tags->add($tag)->shouldHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($tag)->shouldHaveBeenCalled();
    }
}