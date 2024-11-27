<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Event\Tag;

use App\Domain\Event\Tag\TagWasDeleted;
use App\Domain\Tag\TagId;
use JsonSerializable;
use PhpSpec\ObjectBehavior;
use Slick\Event\Event;

/**
 * TagWasDeletedSpec specs
 *
 * @package spec\App\Domain\Event\Tag
 */
class TagWasDeletedSpec extends ObjectBehavior
{
    private $tagId;

    function let()
    {
        $this->tagId = new TagId();
        $this->beConstructedWith($this->tagId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(TagWasDeleted::class);
    }

    function it_has_a_tagId()
    {
        $this->tagId()->shouldBe($this->tagId);
    }

    function it_is_an_event()
    {
        $this->shouldBeAnInstanceOf(Event::class);
    }

    function it_can_be_converted_to_json()
    {
        $this->shouldBeAnInstanceOf(JsonSerializable::class);
        $this->jsonSerialize()->shouldBe([
            'tagId' => $this->tagId
        ]);
    }
}