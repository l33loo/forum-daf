<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Question;

use App\Application\Question\RemoveQuestionCommand;
use App\Domain\Question\QuestionId;
use PhpSpec\ObjectBehavior;

/**
 * RemoveQuestionCommandSpec specs
 *
 * @package spec\App\Application\Question
 */
class RemoveQuestionCommandSpec extends ObjectBehavior
{

    private $questionId;

    function let()
    {
        $this->questionId = new QuestionId();
        $this->beConstructedWith($this->questionId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RemoveQuestionCommand::class);
    }

    function it_has_a_questionId()
    {
        $this->questionId()->shouldBe($this->questionId);
    }

}