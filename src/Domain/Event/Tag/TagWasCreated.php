<?php
declare(strict_types=1);
namespace App\Domain\Event\Tag;

use App\Domain\Tag\TagId;
use JsonSerializable;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * TagWasCreated
 *
 * @package App\Domain\Events\Tags
 */
final class TagWasCreated extends AbstractEvent implements Event, JsonSerializable
{
    /**
     * Creates a TagWasCreated
     *
     * @param TagId $tagId The ID of the tag.
     * @param string $tag The tag text.
     */
    public function __construct(
        private readonly TagId $tagId,
        private readonly string $tag,
    )
    {
        parent::__construct();
    }

    /**
     * TagWasCreated tagId
     *
     * @return TagId
     */
    public function tagId(): TagId
    {
        return $this->tagId;
    }

    /**
     * TagWasCreated tag
     *
     * @return string
     */
    public function tag(): string
    {
        return $this->tag;
    }

    /**
     * @inheritDoc
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'tagId' => $this->tagId,
            'tag' => $this->tag,
        ];
    }
}