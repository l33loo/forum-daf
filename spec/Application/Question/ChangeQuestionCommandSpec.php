<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Question;

use App\Application\Question\ChangeQuestionCommand;
use App\Domain\Question\QuestionId;
use PhpSpec\ObjectBehavior;

/**
 * ChangeQuestionCommandSpec specs
 *
 * @package spec\App\Application\Question
 */
class ChangeQuestionCommandSpec extends ObjectBehavior
{
    private $questionId;
    private $question;
    private $body;

    function let()
    {
        $this->questionId = new QuestionId();
        $this->question = "Question?";
        $this->body = "Body...";

        $this->beConstructedWith($this->questionId, $this->question, $this->body);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ChangeQuestionCommand::class);
    }

    function it_has_question_id()
    {
        $this->questionId()->shouldBe($this->questionId);
    }

    function it_has_question()
    {
        $this->question()->shouldBe($this->question);
    }

    function it_has_body()
    {
        $this->body()->shouldBe($this->body);
    }
}