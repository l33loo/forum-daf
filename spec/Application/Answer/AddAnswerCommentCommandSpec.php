<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Answer;

use App\Application\Answer\AddAnswerCommentCommand;
use App\Domain\Answer\AnswerId;
use PhpSpec\ObjectBehavior;

/**
 * AddAnswerCommentCommandSpec specs
 *
 * @package spec\App\Application\Answer
 */
class AddAnswerCommentCommandSpec extends ObjectBehavior
{
    private $answerId;
    private $comment;

    function let() {
        $this->answerId = new AnswerId();
        $this->comment = "Hello";

        $this->beConstructedWith($this->answerId, $this->comment);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AddAnswerCommentCommand::class);
    }

    function it_has_a_answer_id()
    {
        $this->answerId()->shouldBe($this->answerId);
    }

    function it_has_a_comment()
    {
        $this->comment()->shouldBe($this->comment);
    }
}