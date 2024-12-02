<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Comment;

use App\Domain\Exception\EntityNotFound;
use App\Domain\Comment;
use App\Domain\Comment\CommentId;
use App\Domain\Comment\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * DoctrineCommentRepository
 *
 * @package App\Infrastructure\Doctrine\Comment
 */
final readonly class DoctrineCommentRepository implements CommentRepository
{

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @inheritDoc
     */
    public function add(Comment $comment): Comment
    {
        $this->entityManager->persist($comment);
        return $comment;
    }

    /**
     * @inheritDoc
     */
    public function withId(CommentId $commentId): Comment
    {
        $comment = $this->entityManager->find(Comment::class, $commentId);
        if ($comment instanceof Comment) {
            return $comment;
        }

        throw new EntityNotFound("Comment with id {$commentId} not found");
    }

    /**
     * @inheritDoc
     */
    public function delete(Comment $comment): Comment
    {
        $this->entityManager->remove($comment);
        $this->entityManager->flush();
        return $comment;
    }
}
