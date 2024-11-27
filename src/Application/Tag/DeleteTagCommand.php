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
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\ResourceIdentifier;

#[AsResourceObject('tags')]
final class DeleteTagCommand
{
    public function __construct(
        #[ResourceIdentifier(className: TagId::class)]
        private TagId $tagId
    ) {
    }

    public function tagId()
    {
        return $this->tagId;
    }
}