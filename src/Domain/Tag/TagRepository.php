<?php
declare(strict_types=1);

namespace App\Domain\Tag;

interface TagRepository
{
    public function add(Tag $tag): Tag;
    public function withId(TagId $tagId): Tag;
}