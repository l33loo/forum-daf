<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Tag\Specification;

use App\Domain\ContentValidator;
use App\Domain\Tag;
use App\Domain\Tag\Specification\AcceptableTagSpecification;
use App\Domain\Tag\TagSpecification;
use PhpSpec\ObjectBehavior;

/**
 * AcceptableTagSpecificationSpec specs
 *
 * @package spec\App\Domain\Tag\Specification
 */
class AcceptableTagSpecificationSpec extends ObjectBehavior
{
    private string $tag;

    function let(ContentValidator $validator)
    {
        $this->beConstructedWith($validator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AcceptableTagSpecification::class);
    }

    function its_a_tag_specification()
    {
        $this->shouldImplement(TagSpecification::class);
    }

    function it_fails_when_tag_is_not_valid(
        ContentValidator $validator,
        Tag $tag
    ) {
        $this->tag = 'ATag';
        $tag->tag()->willReturn($this->tag);
        $reasonForRejection = "Inappropriate content";
        $validator->validateContent($this->tag, [])->willReturn(false);
        $validator->reason()->willReturn($reasonForRejection);
        $this->isSatisfiedBy($tag)->shouldReturn(false);
        $this->reason()->shouldBe($reasonForRejection);
    }
}