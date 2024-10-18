<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\Event\User;

use App\Domain\Common\EmailMessage\MessageContent;
use App\Domain\Common\EmailMessage\MessageId;
use App\Domain\User\UserId;
use JsonSerializable;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * ResetPasswordEmailWasSent
 *
 * @package App\Domain\Event\User
 */
final class ResetPasswordEmailWasSent extends AbstractEvent implements Event, JsonSerializable
{


    /**
     * Creates a ResetPasswordEmailWasSent
     *
     * @param UserId $userId
     * @param MessageId $messageId
     * @param MessageContent $message
     */
    public function __construct(
        private readonly UserId $userId,
        private readonly MessageId $messageId,
        private readonly MessageContent $message
    ) {
        parent::__construct();
    }

    /**
     * ResetPasswordEmailWasSent userId
     *
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * ResetPasswordEmailWasSent messageId
     *
     * @return MessageId
     */
    public function messageId(): MessageId
    {
        return $this->messageId;
    }

    /**
     * ResetPasswordEmailWasSent content
     *
     * @return MessageContent
     */
    public function message(): MessageContent
    {
        return $this->message;
    }

    /**
     * @inheritDoc
     * @array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'userId' => $this->userId,
            'messageId' => $this->messageId,
            'message' => $this->message,
        ];
    }
}
