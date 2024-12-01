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

#[AsResourceObject(type: 'tags')]
final class EditTagCommand
{
    public function __construct(
        private TagId $tagId,
        private string $tag
    ) {}

    public function tagId()
    {
        return $this->tagId;
    }

    public function tag()
    {
        return $this->tag;
    }
}