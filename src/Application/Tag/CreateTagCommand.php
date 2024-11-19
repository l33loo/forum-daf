<?php

declare(strict_types=1);
namespace App\Application\Tag;

use Slick\JSONAPI\Object\SchemaDiscover\Attributes\AsResourceObject;

#[AsResourceObject(type: 'tags')]
final class CreateTagCommand
{
    public function __construct(
        #[ResourceAttribute(required: true)]
        private string $tag
    ) {
    }

    public function tag(): string
    {
        return $this->tag;
    }
}