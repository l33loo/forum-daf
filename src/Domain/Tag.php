<?php

declare(strict_types = 1);

namespace App\Domain;

use Doctrine\ORM\Mapping\Table;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\AsResourceObject;

/**
 * Tag
 *
 * @package App\Domain
 */
#[Entity]
#[Table(name: 'tags')]
#[AsResourceObject(type: 'tags')]
class Tag
{

    public function __construct(private ?string $tag)
    {

    }

    public function tag(): ?string
    {
        return $this->tag;
    }
}