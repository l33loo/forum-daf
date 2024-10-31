<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\JsonApi;

use App\Domain\Question;
use Slick\JSONAPI\Object\AbstractResourceSchema;
use Slick\JSONAPI\Object\ResourceSchema;

/**
 * QuestionSchema
 *
 * @package App\Infrastructure\JsonApi
 */
final class QuestionSchema extends AbstractResourceSchema implements ResourceSchema
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
        return "questions";
    }

    /**
     * @inheritDoc
     * @param Question $object
     */
    public function identifier($object): ?string
    {
        return (string) $object->questionId();
    }

    /**
     * @inheritDoc
     * @param Question $object
     */
    public function attributes($object): ?array
    {
        return [
            'question' => $object->question(),
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
     * @param Question $object
     */
    public function relationships($object): ?array
    {
        return [
            'author' => [
                'data' => $object->author(),
            ]
        ];
    }


}
