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
 * TagWasAccepted
 *
 * @package App\Domain\Event\Tag
 */
final class TagWasAccepted extends AbstractEvent implements Event, JsonSerializable
{
    public function __construct(private readonly TagId $tagId)
    {
        parent::__construct();
    }

    /**
     * TagWasAccepted tagId
     *
     * @return TagId
     */
    public function tagId(): TagId
    {
        return $this->tagId;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'tagId' => $this->tagId
        ];
    }
}