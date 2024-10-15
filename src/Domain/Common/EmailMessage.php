<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\Common;

use App\Domain\Common\EmailMessage\MessageContent;
use App\Domain\Common\EmailMessage\MessageId;
use App\Domain\User;

/**
 * EmailMessage
 *
 * @package App\Domain\Common
 */
interface EmailMessage
{

    public function messageId(): MessageId;

    /**
     * Returns the subject of the email message.
     *
     * @return string The subject of the email message.
     */
    public function subject(): string;

    /**
     * Returns the email message as a string.
     *
     * @return MessageContent The message as a string.
     */
    public function message(): MessageContent;

    /**
     * Returns the email recipients as an array.
     *
     * @return array<User|User\Email> The recipients as an array.
     */
    public function recipients(): array;

    /**
     * Returns the context data as an array.
     *
     * @return array<string, mixed> The context data as an array.
     */
    public function context(): array;
}
