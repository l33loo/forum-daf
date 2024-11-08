<?php

declare(strict_types=1);
namespace App\Application\Tag;

use Slick\JSONAPI\Object\SchemaDiscover\Attributes\AsResourceObject;

#[AsResourceObject(type: 'tags')]
final class CreateTagCommand
{
    public function __construct(
        #[ResourceAttribute(required: true)]
        private string $name
    ) {
    }

    public function name(): string
    {
        return $this->name;
    }
}