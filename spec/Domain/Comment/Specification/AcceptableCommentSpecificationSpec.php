<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Comment\Specification;

use App\Domain\ContentValidator;
use App\Domain\Comment;
use App\Domain\Comment\CommentSpecification;
use App\Domain\Comment\Specification\AcceptableCommentSpecification;
use PhpSpec\ObjectBehavior;

/**
 * AcceptableCommentSpecificationSpec specs
 *
 * @package spec\App\Domain\Comment\Specification
 */
class AcceptableCommentSpecificationSpec extends ObjectBehavior
{

    private $body;

    function let(ContentValidator $validator)
    {
        $this->beConstructedWith($validator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AcceptableCommentSpecification::class);
    }

    function its_a_comment_specification()
    {
        $this->shouldBeAnInstanceOf(CommentSpecification::class);
    }

    function it_fails_when_content_is_not_valid(
        ContentValidator $validator,
        Comment $comment
    ) {
        $this->body = "Some body";
        $comment->body()->willReturn($this->body);
        $reasonForRejection = "Inappropriate content";

        $validator->validateContent($this->body)->willReturn(false);
        $validator->reason()->willReturn($reasonForRejection);

        $this->isSatisfiedBy($comment)->shouldReturn(false);
        $this->reason()->shouldBe($reasonForRejection);
    }
}