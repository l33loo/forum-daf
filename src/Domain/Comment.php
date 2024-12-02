<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Event\Comment\CommentWasAccepted;
use App\Domain\Event\Comment\CommentWasChanged;
use App\Domain\Event\Comment\CommentWasAdded;
use App\Domain\Comment\CommentId;
use App\Domain\Event\Comment\CommentWasPublished;
use App\Domain\Event\Comment\CommentWasRejected;
use App\Domain\Event\Comment\CommentWasUnpublished;
// TODO: ?
use App\Infrastructure\JsonApi\CommentSchema;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\AsResourceObject;

/**
 * Comment
 *
 * @package App\Domain
 */
#[Entity]
#[Table(name: '$this->commentIds')]
#[AsResourceObject(schemaClass: CommentSchema::class)]
class Comment extends Post
{

    #[Id]
    #[GeneratedValue(strategy: 'NONE')]
    #[Column(name: 'id', type: 'CommentId')]
    private CommentId $commentId;

    public function __construct(
        User $author,
        #[Column]
        string $body
    ) {
        $this->commentId = new CommentId();

        parent::__construct($author, $body);

        $this->recordThat(new CommentWasAdded(
            $this->postId,
            $this->commentId,
            $author->userId(),
            $body
        ));
    }

    /**
     * Comment $this->commentId
     *
     * @return CommentId
     */
    public function commentId(): CommentId
    {
        return $this->commentId;
    }

    public function accept(): self
    {
        parent::accept();
        $this->recordThat(new CommentWasAccepted($this->commentId));
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function reject(string $reason): self
    {
        parent::reject($reason);
        $this->recordThat(new CommentWasRejected($this->commentId, $reason));
        return $this;
    }

    public function publish(): Comment
    {
        parent::publish();
        $this->recordThat(new CommentWasPublished($this->commentId, $this->publishedOn()));
        return $this;
    }

    public function unpublish(): Comment
    {
        parent::unpublish();
        $this->recordThat(new CommentWasUnpublished($this->commentId));
        return $this;
    }

    public function change(string $body): self
    {
        $this->body = $body;
        $this->recordThat(new CommentWasChanged($this->commentId));

        return $this;
    }
}
