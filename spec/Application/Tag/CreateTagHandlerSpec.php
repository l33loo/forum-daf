<?php
namespace spec\App\Application\Question;

use App\Domain\Tag;
use PhpSpec\ObjectBehavior;

class CreateTagHandlerSpec extends ObjectBehavior
{
    private $tag;

    function let(
        Tag $tag
    )
    {
        $this->tag = new Tag('hello');
    }
}