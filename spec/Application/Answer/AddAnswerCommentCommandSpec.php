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
use App\Domain\Post\PostId;
use App\Domain\User\UserId;
use PhpSpec\ObjectBehavior;

/**
 * AddAnswerCommentCommandSpec specs
 *
 * @package spec\App\Application\Answer
 */
class AddAnswerCommentCommandSpec extends ObjectBehavior
{
    private $answerId;
    private $postId;
    private $body;
    private $authorId;

    function let() {
        $this->answerId = new AnswerId();
        $this->postId = new PostId();
        $this->body = "Hello";
        $this->authorId = new UserId();

        $this->beConstructedWith($this->answerId, $this->postId, $this->body, $this->authorId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AddAnswerCommentCommand::class);
    }

    function it_has_a_answerId()
    {
        $this->answerId()->shouldBe($this->answerId);
    }

    function it_has_a_postId()
    {
        $this->postId()->shouldBe($this->postId);
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