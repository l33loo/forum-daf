<?php

declare(strict_types = 1);

namespace App\Domain;

use App\Domain\Event\Tag\TagWasAccepted;
use App\Domain\Event\Tag\TagWasCreated;
use App\Domain\Event\Tag\TagWasDeleted;
use App\Domain\Event\Tag\TagWasEdited;
use App\Domain\Event\Tag\TagWasRejected;
use App\Domain\Tag\TagId;
use App\Infrastructure\JsonApi\TagSchema;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\Table;
use Slick\Event\EventGenerator;
use Slick\Event\Domain\EventGeneratorMethods;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\AsResourceObject;

/**
 * Tag
 *
 * @package App\Domain
 */
#[Entity]
#[Table(name: 'tags')]
#[AsResourceObject(schemaClass: TagSchema::class)]
class Tag implements EventGenerator
{
    use EventGeneratorMethods;

    #[Id]
    #[GeneratedValue(strategy: 'NONE')]
    #[Column(name: 'id', type: 'TagId')]
    private TagId $tagId;

    #[ManyToMany(targetEntity: Question::class, mappedBy: 'tags')]
    private ?Collection $questions = null;

    public function __construct(
        #[Column]
        private string $tag
    ) {
        $this->tagId = new TagId();
        $this->questions = new ArrayCollection();

        $this->recordThat(new TagWasCreated(
            $this->tagId,
            $this->tag
        ));
    }

    public function tag(): string
    {
        return $this->tag;
    }

    public function tagId(): TagId
    {
        return $this->tagId;
    }

    public function accept(): self
    {
        $this->recordThat(new TagWasAccepted($this->tagId));
        return $this;
    }

    public function reject(string $reason): self
    {
        $this->recordThat(new TagWasRejected($this->tagId, $reason));
        return $this;
    }

    public function remove(): self
    {
        $this->recordThat(new TagWasDeleted($this->tagId));
        return $this;
    }

    public function edit(string $newTag): self
    {
        $this->tag = $newTag;
        $this->recordThat(new TagWasEdited($this->tagId, $newTag));
        return $this;
    }

    public function questions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        $this->questions->removeElement($question);

        return $this;
    }
}