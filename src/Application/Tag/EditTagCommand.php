<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Tag;

use App\Domain\Tag\TagId;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\AsResourceObject;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\ResourceAttribute;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\ResourceIdentifier;

#[AsResourceObject(type: 'tags')]
final class EditTagCommand
{
    public function __construct(
        #[ResourceIdentifier(className: TagId::class, required: true)]
        private readonly TagId $tagId,
        #[ResourceAttribute(required: true)]
        private readonly string $tag
    ) {}

    public function tagId(): TagId
    {
        return $this->tagId;
    }

    public function tag(): string
    {
        return $this->tag;
    }
}