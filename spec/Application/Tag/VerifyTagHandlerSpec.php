<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Tag;

use App\Application\Tag\VerifyTagHandler;
use App\Domain\Tag;
use App\Domain\Tag\Specification\AcceptableTagSpecification;
use App\Domain\Tag\TagRepository;
use PhpSpec\ObjectBehavior;
use Slick\Event\EventDispatcher;

class VerifyTagHandlerSpec extends ObjectBehavior
{
    private $tag;
    private $reason;

    function let(
        TagRepository $tags,
        AcceptableTagSpecification $acceptable,
        EventDispatcher $dispatcher,
        Tag $tag
    ) {
        $this->tag = "hello";
        $this->reason = "bad tag";
        $tags->withTagText($this->tag)->willReturn($tag);

        $acceptable->isSatisfiedBy($tag)->willReturn(true);
//        $tag->accept()->willReturn($tag);
        $tag->reject($this->reason)->willReturn($tag);

        $dispatcher->dispatchEventsFrom($tag)->willReturn([]);

        $this->beConstructedWith($tags, $acceptable, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(VerifyTagHandler::class);
    }
}