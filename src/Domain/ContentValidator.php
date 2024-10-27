<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain;

/**
 * ContentValidator
 *
 * @package App\Domain
 */
interface ContentValidator
{

    /**
     * Validates the content with the given context.
     *
     * @param string $content The content to be validated.
     * @param array $context Additional context for validation.
     *
     * @return bool Returns true if the content is valid, false otherwise.
     */
    public function validateContent(string $content, array $context = []): bool;

    /**
     * Gets the reason content analysis
     *
     * @return string|null The reason for the specific action.
     */
    public function reason(): ?string;
}
