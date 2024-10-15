<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\Common\EmailMessage;

/**
 * MessageContent
 *
 * @package App\Domain\Common\EmailMessage
 */
final readonly class MessageContent
{


    /**
     * Creates a MessageContent
     *
     * @param string $primaryContent
     * @param string|null $alternativeContent
     */
    public function __construct(
        private string $primaryContent,
        private ?string $alternativeContent = null,
    ) {
    }

    /**
     * MessageContent primaryContent
     *
     * @return string
     */
    public function primaryContent(): string
    {
        return $this->primaryContent;
    }

    /**
     * MessageContent alternativeContent
     *
     * @return string|null
     */
    public function alternativeContent(): ?string
    {
        return $this->alternativeContent;
    }
}
