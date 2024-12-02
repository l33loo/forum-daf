<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Comment;

use App\Domain\Comment\CommentId;

/**
 * VerifyCommentCommand
 *
 * @package App\Application\Comment
 */
final readonly class VerifyCommentCommand
{


    public function __construct(private CommentId $commentId)
    {
    }

    /**
     * VerifyCommentCommand commentId
     *
     * @return CommentId
     */
    public function commentId(): CommentId
    {
        return $this->commentId;
    }
}
