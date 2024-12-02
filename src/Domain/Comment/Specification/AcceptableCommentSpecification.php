<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\Comment\Specification;

use App\Domain\ContentValidator;
use App\Domain\Comment;
use App\Domain\Comment\CommentSpecification;

/**
 * AcceptableCommentSpecification
 *
 * @package App\Domain\Comment\Specification
 */
class AcceptableCommentSpecification implements CommentSpecification
{

    private ?string $reason = null;

    public function __construct(private readonly ContentValidator $validator)
    {
    }


    public function isSatisfiedBy(Comment $comment): bool
    {
        if ($this->validator->validateContent($comment->body())) {
            return true;
        }

        $this->reason = $this->validator->reason();
        return false;
    }

    /**
     * AcceptableCommentSpecification reason
     *
     * @return string|null
     */
    public function reason(): ?string
    {
        return $this->reason;
    }
}
