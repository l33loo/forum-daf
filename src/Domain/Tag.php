<?php

declare(strict_types = 1);

namespace App\Domain;

use App\Domain\Event\Tag\TagWasCreated;
use App\Domain\Event\Tag\TagWasRejected;
use App\Domain\Tag\TagId;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
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
#[AsResourceObject(type: 'tags')]
class Tag implements EventGenerator
{
    use EventGeneratorMethods;

    #[Id]
    #[GeneratedValue(strategy: 'NONE')]
    #[Column(name: 'id', type: 'TagId')]
    private TagId $tagId;

    public function __construct(
        #[Column]
        private string $tag
    ) {
        $this->tagId = new TagId();

        $this->recordThat(new TagWasCreated(
            $this->tagId,
            $this->tag
        ));
    }

    public function tag(): string
    {
        return $this->tag;
    }

    public function reject(string $reason): self
    {
        $this->recordThat(new TagWasRejected($this->tagId, $reason));
        return $this;
    }
}