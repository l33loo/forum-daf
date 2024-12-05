<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Answer\AnswerId;
use App\Domain\Event\Answer\AnswerWasAccepted;
use App\Domain\Event\Answer\AnswerWasChanged;
use App\Domain\Event\Answer\AnswerWasPublished;
use App\Domain\Event\Answer\AnswerWasRejected;
use App\Domain\Event\Answer\AnswerWasUnpublished;
use App\Infrastructure\JsonApi\AnswerSchema;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\InverseJoinColumn;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\AsResourceObject;

/**
 * Answer
 *
 * @package App\Domain
 */
#[Entity]
#[Table(name: 'answers')]
#[AsResourceObject(schemaClass: AnswerSchema::class)]
class Answer extends Post
{
    use CommentTrait;

    #[Id]
    #[GeneratedValue(strategy: 'NONE')]
    #[Column(name: 'id', type: 'AnswerId')]
    private AnswerId $answerId;

    #[ManyToOne(targetEntity: Question::class, inversedBy: 'answers')]
    private Question $question;

    #[JoinTable(name: 'answer_comment')]
    #[JoinColumn(name: 'answer_id', referencedColumnName: 'id')]
    #[InverseJoinColumn(name: 'comment_id', referencedColumnName: 'id', unique: true)]
    #[ManyToMany(targetEntity: Comment::class)]
    private ?Collection $comments = null;

    #[OneToMany(targetEntity: Vote::class, mappedBy: 'answer', cascade: ['all'], orphanRemoval: true)]
    private ?Collection $votes = null;

    public function __construct(
        User $user,
        string $body,
        Question $question
    ) {
        $this->answerId = new AnswerId();
        $this->comments = new ArrayCollection();
        $this->question = $question;
        $this->votes = new ArrayCollection();

        parent::__construct($user, $body);
    }

    /**
     * Answer answerId
     *
     * @return AnswerId
     */
    public function answerId(): AnswerId
    {
        return $this->answerId;
    }

    public function accept(): self
    {
        parent::accept();
        $this->recordThat(new AnswerWasAccepted($this->answerId));
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function reject(string $reason): self
    {
        parent::reject($reason);
        $this->recordThat(new AnswerWasRejected($this->answerId, $reason));
        return $this;
    }

    public function publish(): Answer
    {
        parent::publish();
        $this->recordThat(new AnswerWasPublished($this->answerId, $this->publishedOn()));
        return $this;
    }

    public function unpublish(): Answer
    {
        parent::unpublish();
        $this->recordThat(new AnswerWasUnpublished($this->answerId));
        return $this;
    }

    public function change(string $body): self
    {
        $this->body = $body;
        $this->recordThat(new AnswerWasChanged($this->answerId));

        return $this;
    }

    public function question(): Question
    {
        return $this->question;
    }

    public function votes(): Collection
    {
        return $this->votes;
    }
}
