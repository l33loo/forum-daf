<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\JsonApi;

use App\Domain\Tag;
use Slick\JSONAPI\Object\AbstractResourceSchema;
use Slick\JSONAPI\Object\ResourceSchema;

/**
 * TagSchema
 *
 * @package App\Infrastructure\JsonApi
 */
final class TagSchema extends AbstractResourceSchema implements ResourceSchema
{
    /**
     * @inheritDoc
     */
    public function isCompound(): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function type($object): string
    {
        return "tags";
    }

    /**
     * @inheritDoc
     * @param Tag $object
     */
    public function identifier($object): ?string
    {
        return (string) $object->tagId();
    }

    /**
     * @inheritDoc
     * @param Tag $object
     */
    public function attributes($object): ?array
    {
        return [
            'tag' => $object->tag(),
        ];
    }

    /**
     * @inheritDoc
     * @param Tag $object
     */
    public function relationships($object): ?array
    {
        return [
            'questions' => [
                'data' => $object->questions(),
            ],
        ];
    }
}
