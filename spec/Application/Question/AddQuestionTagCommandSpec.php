<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Question;

use App\Application\Question\AddQuestionTagCommand;
use App\Domain\Question;
use App\Domain\Question\QuestionId;
use App\Domain\Question\QuestionRepository;
use App\Domain\Tag;
use App\Domain\Tag\TagRepository;
use PhpSpec\ObjectBehavior;

/**
 * AddQuestionTagCommandSpec specs
 *
 * @package spec\App\Application\Question
 */
class AddQuestionTagCommandSpec extends ObjectBehavior
{
    private $questionId;
    private $tag;

    function let() {
        $this->questionId = new QuestionId();
        $this->tag = "Hello";

        $this->beConstructedWith($this->questionId, $this->tag);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AddQuestionTagCommand::class);
    }

    function it_has_a_question_id()
    {
        $this->questionId()->shouldBe($this->questionId);
    }

    function it_has_a_tag()
    {
        $this->tag()->shouldBe($this->tag);
    }
}