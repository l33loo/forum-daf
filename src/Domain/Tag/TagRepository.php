<?php
declare(strict_types=1);

namespace App\Domain\Tag;

use App\Domain\DomainException;
use App\Domain\Exception\EntityNotFound;
use App\Domain\Tag;

/**
 * TagRepository
 *
 * @package App\Domain\Tag
 */
interface TagRepository
{
    /**
     * Add a tag to the repository
     *
     * @param Tag $tag The tag to be added
     * @return Tag The added tag
     */
    public function add(Tag $tag): Tag;

    /**
     * Get a tag by its ID
     *
     * @param TagId $tagId The ID of the tag to retrieve
     * @return Tag The tag with the specified ID
     * @throws DomainException|EntityNotFound When there are no tags with provided identifier
     */
    public function withId(TagId $tagId): Tag;
}