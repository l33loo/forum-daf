<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\JsonApi;

use App\Domain\Vote;
use Slick\JSONAPI\Object\AbstractResourceSchema;
use Slick\JSONAPI\Object\ResourceSchema;

/**
 * VoteSchema
 *
 * @package App\Infrastructure\JsonApi
 */
final class VoteSchema extends AbstractResourceSchema implements ResourceSchema
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
        return "votes";
    }

    /**
     * @inheritDoc
     * @param Vote $object
     */
    public function identifier($object): ?string
    {
        return (string) $object->voteId();
    }

    /**
     * @inheritDoc
     * @param Vote $object
     */
    public function attributes($object): ?array
    {
        return [
            'intention' => $object->intention(),
        ];
    }

    /**
     * @inheritDoc
     * @param Vote $object
     */
    public function relationships($object): ?array
    {
        return [
            'user' => [
                'data' => $object->user(),
            ],
            'answer' => [
                'data' => $object->answer(),
            ],
        ];
    }
}
