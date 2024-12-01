<?php

declare(strict_types=1);
namespace App\Application\Tag;

use App\Domain\Tag;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\AsResourceObject;

#[AsResourceObject(type: 'tags')]
final class CreateTagCommand
{
    public function __construct(
        #[ResourceAttribute(required: true)]
        private Tag $tag
    ) {
    }

    public function tag(): Tag
    {
        return $this->tag;
    }
}