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
use JsonSerializable;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * TagWasRejected
 *
 * @package App\Domain\Event\Tag
 */
final class TagWasRejected extends AbstractEvent implements Event, JsonSerializable
{
    /**
     * Creates a TagWasRejected
     *
     * @param TagId $tagId
     * @param
     */
    public function __construct(
        private readonly TagId $tagId,
        private readonly string $rejectReason
    ) {
        parent::__construct();
    }

    public function tagId(): TagId
    {
        return $this->tagId;
    }

    public function rejectReason(): string
    {
        return $this->rejectReason;
    }

    public function jsonSerialize(): array
    {
        return [
            'rejectReason' => $this->rejectReason,
            'tagId' => $this->tagId,
        ];
    }
}