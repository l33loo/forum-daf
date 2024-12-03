<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Question;

use App\Application\Question\AddQuestionCommentCommand;
use App\Domain\Post\PostId;
use App\Domain\Question\QuestionId;
use App\Domain\User\UserId;
use PhpSpec\ObjectBehavior;

/**
 * AddQuestionCommentCommandSpec specs
 *
 * @package spec\App\Application\Question
 */
class AddQuestionCommentCommandSpec extends ObjectBehavior
{
    private $questionId;
    private $postId;
    private $body;
    private $authorId;

    function let() {
        $this->questionId = new QuestionId();
        $this->postId = new PostId();
        $this->body = "Hello";
        $this->authorId = new UserId();

        $this->beConstructedWith($this->questionId, $this->postId, $this->body, $this->authorId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AddQuestionCommentCommand::class);
    }

    function it_has_a_question_id()
    {
        $this->questionId()->shouldBe($this->questionId);
    }

    function it_has_a_body()
    {
        $this->body()->shouldBe($this->body);
    }

    function it_has_an_authorId()
    {
        $this->authorId()->shouldBe($this->authorId);
    }
}