<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\Tag\Specification;

use App\Domain\ContentValidator;
use App\Domain\Tag;
use App\Domain\Tag\TagSpecification;

/**
 * AcceptableTagSpecification
 *
 * @package App\Domain\Tag\Specification
 */
class AcceptableTagSpecification implements TagSpecification
{
    private ?string $reason = null;

    public function __construct(private readonly ContentValidator $validator)
    {}

    public function isSatisfiedBy(Tag $tag): bool
    {
        if ($this->validator->validateContent($tag->tag(), []))
        {
            return true;
        }

        $this->reason = $this->validator->reason();
        return false;
    }

    public function reason(): ?string
    {
        return $this->reason;
    }
}