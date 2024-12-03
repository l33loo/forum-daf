<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Event\Comment\CommentWasAdded;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\OneToMany;

trait CommentTrait {
    // TODO: complete
//    #[OneToMany(targetEntity: Comment::class, mappedBy: 'comment', cascade: ['all'], orphanRemoval: true)]
    private ?Collection $comments = null;

    public function comments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        $this->comments->add($comment);
        $this->recordThat(new CommentWasAdded($this->postId, $comment->commentId(), $comment->author()->userId(), $comment->body()));

        return $this;
    }
}