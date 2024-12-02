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
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\AsResourceObject;

#[AsResourceObject(type: "comments")]
final class ChangeCommentCommand
{
    public function __construct(
        private CommentId $commentId,
        private string $body
    ) {}

    public function commentId(): CommentId
    {
        return $this->commentId;
    }

    public function comment(): string
    {
        return $this->comment;
    }

    public function body(): string
    {
        return $this->body;
    }
}