<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Question\Specification;

use App\Domain\ContentValidator;
use App\Domain\Question;
use App\Domain\Question\QuestionSpecification;
use App\Domain\Question\Specification\AcceptableQuestionSpecification;
use PhpSpec\ObjectBehavior;

/**
 * AcceptableQuestionSpecificationSpec specs
 *
 * @package spec\App\Domain\Question\Specification
 */
class AcceptableQuestionSpecificationSpec extends ObjectBehavior
{

    private $body;
    private $question;

    function let(ContentValidator $validator)
    {
        $this->beConstructedWith($validator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AcceptableQuestionSpecification::class);
    }

    function its_a_question_specification()
    {
        $this->shouldBeAnInstanceOf(QuestionSpecification::class);
    }

    function it_fails_when_content_is_not_valid(
        ContentValidator $validator,
        Question $question
    ) {
        $this->body = "Some body";
        $this->question = 'A title?';
        $question->body()->willReturn($this->body);
        $question->question()->willReturn($this->question);
        $reasonForRejection = "Inappropriate content";

        $validator->validateContent($this->body, [
            'question' => $this->question,
        ])->willReturn(false);
        $validator->reason()->willReturn($reasonForRejection);

        $this->isSatisfiedBy($question)->shouldReturn(false);
        $this->reason()->shouldBe($reasonForRejection);
    }
}