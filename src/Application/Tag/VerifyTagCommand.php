<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Tag;

use App\Domain\Tag;

/**
 * VerifyTagCommand
 *
 * @package App\Application\Tag
 */
final readonly class VerifyTagCommand
{
    public function __construct(private string $tag)
    {}

    /**
     * VerifyTagCommand tag
     *
     * @return string
     */
    public function tag(): string
    {
        return $this->tag;
    }
}