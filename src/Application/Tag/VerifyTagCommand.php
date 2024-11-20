<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Tag;

use App\Domain\Question\QuestionId;
use App\Domain\Tag\TagId;

/**
 * VerifyTagCommand
 *
 * @package App\Application\Tag
 */
final readonly class VerifyTagCommand
{
    public function __construct(private TagId $tagId)
    {}

    /**
     * VerifyTagCommand tagId
     *
     * @return TagId
     */
    public function tagId(): TagId
    {
        return $this->tagId;
    }
}