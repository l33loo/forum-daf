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
 * TagWasEdited
 *
 * @package App\Domain\Events\Tags
 */
final class TagWasEdited extends AbstractEvent implements Event, \JsonSerializable
{
    public function __construct(
        private TagId $tagId,
        private string $newTag
    ) {
        parent::__construct();
    }

    public function tagId(): TagId
    {
        return $this->tagId;
    }

    public function newTag(): string
    {
        return $this->newTag;
    }

    public function jsonSerialize(): array
    {
        return [
            'tagId' => $this->tagId,
            'newTag' => $this->newTag
        ];
    }
}