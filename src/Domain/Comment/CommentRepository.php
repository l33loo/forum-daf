<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\Comment;

use App\Domain\DomainException;
use App\Domain\Exception\EntityNotFound;
use App\Domain\Comment;

/**
 * CommentRepository
 *
 * @package App\Domain\Comment
 */
interface CommentRepository
{

    /**
     * Add a comment to the repository
     *
     * @param Comment $comment The comment to be added
     * @return Comment The added comment
     */
    public function add(Comment $comment): Comment;

    /**
     * Get a comment by its ID
     *
     * @param CommentId $commentId The ID of the comment to retrieve
     * @return Comment The comment with the specified ID
     * @throws DomainException|EntityNotFound When there are no comments with provided identifier
     */
    public function withId(CommentId $commentId): Comment;

    /**
     * Delete a comment from the repository
     *
     * @param Comment $comment The comment to be deleted
     * @return Comment The deleted comment
     */
    public function delete(Comment $comment): Comment;
}
