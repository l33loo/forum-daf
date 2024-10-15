<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\Common\EmailMessage;

use phpDocumentor\Reflection\Types\Context;

/**
 * EmailContentCreator
 *
 * @package App\Domain\Common\EmailMessage
 */
interface EmailContentCreator
{

    /**
     * Creates content for the specified class name.
     *
     * @param class-string $className The name of the class for which to create content
     * @param array<string, mixed>|null $context for rendering content
     * @return MessageContent The content created for the specified class name
     */
    public function createContentFor(string $className, ?array $context = []): MessageContent;
}
