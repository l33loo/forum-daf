<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\JsonApi;

use App\Domain\Answer;
use Slick\JSONAPI\Object\AbstractResourceSchema;
use Slick\JSONAPI\Object\ResourceSchema;

/**
 * AnswerSchema
 *
 * @package App\Infrastructure\JsonApi
 */
final class AnswerSchema extends AbstractResourceSchema implements ResourceSchema
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
        return "answers";
    }

    /**
     * @inheritDoc
     * @param Answer $object
     */
    public function identifier($object): ?string
    {
        return (string) $object->answerId();
    }

    /**
     * @inheritDoc
     * @param Answer $object
     */
    public function attributes($object): ?array
    {
        return [
            'body' => $object->body(),
            'postId' => (string) $object->postId(),
            'published' => $object->isPublished(),
            'publishedOn' => $object->publishedOn()?->format(DATE_W3C),
            'accepted' => $object->isAccepted(),
            'rejectReason' => $object->rejectReason(),
        ];
    }

    /**
     * @inheritDoc
     * @param Answer $object
     */
    public function relationships($object): ?array
    {
        return [
            'author' => [
                'data' => $object->author(),
            ],
            'question' => [
                'data' => $object->question(),
            ],
            'votes' => [
                'data' => $object->votes(),
            ],
        ];
    }
}
