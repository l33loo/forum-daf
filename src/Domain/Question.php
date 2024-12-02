<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Event\Question\QuestionHasChanged;
use App\Domain\Event\Question\QuestionWasAccepted;
use App\Domain\Event\Question\QuestionWasPosted;
use App\Domain\Event\Question\QuestionWasPublished;
use App\Domain\Event\Question\QuestionWasRejected;
use App\Domain\Event\Question\QuestionWasUnpublished;
use App\Domain\Event\Question\TagWasAdded;
use App\Domain\Event\Question\TagWasRemoved;
use App\Domain\Question\QuestionId;
use App\Infrastructure\JsonApi\QuestionSchema;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\Table;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\AsResourceObject;

/**
 * Question
 *
 * @package App\Domain
 */
#[Entity]
#[Table(name: 'questions')]
#[AsResourceObject(schemaClass: QuestionSchema::class)]
class Question extends Post
{
    use CommentTrait;

    #[Id]
    #[GeneratedValue(strategy: 'NONE')]
    #[Column(name: 'id', type: 'QuestionId')]
    private QuestionId $questionId;

    // TODO: Fix
    #[ManyToMany(targetEntity: Tag::class)]
    #[JoinColumn(name: 'tag_id', referencedColumnName: 'id')]
    private ?Collection $tags = null;

    public function __construct(
        User $user,
        // TODO: Check
        #[Column]
        private string $question,
        string $body
    ) {
        $this->questionId = new QuestionId();
        $this->tags = new ArrayCollection();
        $this->comments = new ArrayCollection();

        parent::__construct($user, $body);

        $this->recordThat(new QuestionWasPosted(
            $this->questionId,
            $user->userId(),
            $this->question,
            $body
        ));
    }

    /**
     * Question's question
     *
     * @return string
     */
    public function question(): string
    {
        return $this->question;
    }

    /**
     * Question questionId
     *
     * @return QuestionId
     */
    public function questionId(): QuestionId
    {
        return $this->questionId;
    }

    public function accept(): self
    {
         parent::accept();
        $this->recordThat(new QuestionWasAccepted($this->questionId));
         return $this;
    }

    /**
     * @inheritDoc
     */
    public function reject(string $reason): self
    {
        parent::reject($reason);
        $this->recordThat(new QuestionWasRejected($this->questionId, $reason));
        return $this;
    }

    public function publish(): Question
    {
        parent::publish();
        $this->recordThat(new QuestionWasPublished($this->questionId, $this->publishedOn()));
        return $this;
    }

    public function unpublish(): Question
    {
        parent::unpublish();
        $this->recordThat(new QuestionWasUnpublished($this->questionId));
        return $this;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $tag->addQuestion($this);
            $this->tags[] = $tag;
            $this->recordThat(new TagWasAdded($this->questionId, $tag));
        }

        return $this;
    }

    public function tags(): Collection
    {
        return $this->tags;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removeQuestion($this);
            $this->recordThat(new TagWasRemoved($this->questionId, $tag));
        }

        return $this;
    }

    public function change(string $question, string $body): self
    {
        $this->question = $question;
        $this->body = $body;
        $this->recordThat(new QuestionHasChanged($this->questionId));

        return $this;
    }
}
