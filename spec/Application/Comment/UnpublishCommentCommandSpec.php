<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Comment;

use App\Application\Comment\UnpublishCommentCommand;
use App\Domain\Comment\CommentId;
use PhpSpec\ObjectBehavior;

/**
 * UnpublishCommentCommandSpec specs
 *
 * @package spec\App\Application\Comment
 */
class UnpublishCommentCommandSpec extends ObjectBehavior
{

    private $commentId;

    function let()
    {
        $this->commentId = new CommentId();
        $this->beConstructedWith($this->commentId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UnpublishCommentCommand::class);
    }

    function it_has_a_commentId()
    {
        $this->commentId()->shouldBe($this->commentId);
    }

}