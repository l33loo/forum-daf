<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\JsonApi;

use App\Domain\Comment;
use Slick\JSONAPI\Object\AbstractResourceSchema;
use Slick\JSONAPI\Object\ResourceSchema;

/**
 * CommentSchema
 *
 * @package App\Infrastructure\JsonApi
 */
final class CommentSchema extends AbstractResourceSchema implements ResourceSchema
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
        return "comments";
    }

    /**
     * @inheritDoc
     * @param Comment $object
     */
    public function identifier($object): ?string
    {
        return (string) $object->commentId();
    }

    /**
     * @inheritDoc
     * @param Comment $object
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
     * @param Comment $object
     */
    public function relationships($object): ?array
    {
        return [
            'author' => [
                'data' => $object->author(),
            ],
            'answer' => [
                'data' => $object->answer(),
            ],
        ];
    }
}
