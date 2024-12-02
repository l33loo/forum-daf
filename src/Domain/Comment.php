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
    private CommentId $commentIdId;

    public function __construct(
        User $user,
        #[Column]
        string $body
    ) {
        $this->commentIdId = new CommentId();

        parent::__construct($user, $body);

        $this->recordThat(new CommentWasAdded(
            $this->commentIdId,
            $user->userId(),
            $body
        ));
    }

    /**
     * Comment $this->commentIdId
     *
     * @return CommentId
     */
    public function commentIdId(): CommentId
    {
        return $this->commentIdId;
    }

    public function accept(): self
    {
        parent::accept();
        $this->recordThat(new CommentWasAccepted($this->commentIdId));
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function reject(string $reason): self
    {
        parent::reject($reason);
        $this->recordThat(new CommentWasRejected($this->commentIdId, $reason));
        return $this;
    }

    public function publish(): Comment
    {
        parent::publish();
        $this->recordThat(new CommentWasPublished($this->commentIdId, $this->publishedOn()));
        return $this;
    }

    public function unpublish(): Comment
    {
        parent::unpublish();
        $this->recordThat(new CommentWasUnpublished($this->commentIdId));
        return $this;
    }

    public function change(string $body): self
    {
        $this->body = $body;
        $this->recordThat(new CommentWasChanged($this->commentIdId));

        return $this;
    }
}
