<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Answer\Specification;

use App\Domain\ContentValidator;
use App\Domain\Answer;
use App\Domain\Answer\AnswerSpecification;
use App\Domain\Answer\Specification\AcceptableAnswerSpecification;
use PhpSpec\ObjectBehavior;

/**
 * AcceptableAnswerSpecificationSpec specs
 *
 * @package spec\App\Domain\Answer\Specification
 */
class AcceptableAnswerSpecificationSpec extends ObjectBehavior
{

    private $body;

    function let(ContentValidator $validator)
    {
        $this->beConstructedWith($validator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AcceptableAnswerSpecification::class);
    }

    function its_an_answer_specification()
    {
        $this->shouldBeAnInstanceOf(AnswerSpecification::class);
    }

    function it_fails_when_content_is_not_valid(
        ContentValidator $validator,
        Answer $answer
    ) {
        $this->body = "Some body";
        $answer->body()->willReturn($this->body);
        $reasonForRejection = "Inappropriate content";

        $validator->validateContent($this->body)->willReturn(false);
        $validator->reason()->willReturn($reasonForRejection);

        $this->isSatisfiedBy($answer)->shouldReturn(false);
        $this->reason()->shouldBe($reasonForRejection);
    }
}