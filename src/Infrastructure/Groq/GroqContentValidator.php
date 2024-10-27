<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\Groq;

use App\Domain\ContentValidator;

/**
 * GroqContentValidator
 *
 * @package App\Infrastructure\Groq
 */
final class GroqContentValidator implements ContentValidator
{

    /**
     * @inheritDoc
     */
    public function validateContent(string $content, array $context = []): bool
    {
        // TODO: Implement validateContent() method.
    }

    /**
     * @inheritDoc
     */
    public function reason(): ?string
    {
        // TODO: Implement reason() method.
    }
}
