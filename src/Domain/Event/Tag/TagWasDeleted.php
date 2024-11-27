<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\Event\Tag;

use App\Domain\Tag\TagId;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * TagWasDeleted
 *
 * @package App\Domain\Event\Tag
 */
final class TagWasDeleted extends AbstractEvent implements Event, \JsonSerializable
{
    /**
     * Creates a TagWasDeleted
     *
     * @param TagId $tagId
     */
    public function __construct(private TagId $tagId)
    {
    }

    public function tagId(): TagId
    {
        return $this->tagId;
    }

    public function jsonSerialize(): array
    {
        return [
            'tagId' => $this->tagId
        ];
    }
}