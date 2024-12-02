<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Comment;

use App\Application\Comment\ChangeCommentCommand;
use App\Domain\Comment\CommentId;
use PhpSpec\ObjectBehavior;

/**
 * ChangeCommentCommandSpec specs
 *
 * @package spec\App\Application\Comment
 */
class ChangeCommentCommandSpec extends ObjectBehavior
{
    private $commentId;
    private $body;

    function let()
    {
        $this->commentId = new CommentId();
        $this->body = "Body...";

        $this->beConstructedWith($this->commentId, $this->body);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ChangeCommentCommand::class);
    }

    function it_has_comment_id()
    {
        $this->commentId()->shouldBe($this->commentId);
    }

    function it_has_body()
    {
        $this->body()->shouldBe($this->body);
    }
}