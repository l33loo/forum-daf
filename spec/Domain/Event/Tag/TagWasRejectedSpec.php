<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Event\Tag;

use App\Domain\Tag\TagId;
use App\Domain\Event\Tag\TagWasRejected;
use JsonSerializable;
use PhpSpec\ObjectBehavior;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * TagWasRejectedSpec specs
 *
 * @package spec\App\Domain\Event\Tag
 */
class TagWasRejectedSpec extends ObjectBehavior
{
     private $tagId;
     private $rejectReason;

     function let()
     {
        $this->tagId = new TagId();
        $this->rejectReason = 'Invalid tag';
        $this->beConstructedWith($this->tagId, $this->rejectReason);
     }

     function it_is_initializable()
     {
         $this->shouldHaveType(TagWasRejected::class);
     }

     function it_has_a_tagId()
     {
         $this->tagId()->shouldBe($this->tagId);
     }

     function it_has_a_rejectReason()
     {
        $this->rejectReason()->shouldBe($this->rejectReason);
     }

     function its_an_event()
     {
         $this->shouldBeAnInstanceOf(Event::class);
         $this->shouldImplement(AbstractEvent::class);
         $this->occurredOn()->shouldBeAnInstanceOf(\DateTimeImmutable::class);
     }

     function it_can_be_converted_to_json()
     {
         $this->shouldImplement(JsonSerializable::class);
         $this->jsonSerialize()->shouldBeLike([
             'tagId' => $this->tagId,
             'rejectReason' => $this->rejectReason,
         ]);
     }
}