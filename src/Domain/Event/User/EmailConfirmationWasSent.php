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
 * EmailConfirmationWasSent
 *
 * @package App\Domain\Event\User
 */
final class EmailConfirmationWasSent extends AbstractEvent implements Event, JsonSerializable
{


    /**
     * Creates a EmailConfirmationWasSent
     *
     * @param UserId $userId The user id
     * @param MessageId $messageId The message id
     * @param MessageContent $message The message content
     */
    public function __construct(
        private readonly UserId $userId,
        private readonly MessageId $messageId,
        private readonly MessageContent $message
    ) {
        parent::__construct();
    }

    /**
     * EmailConfirmationWasSent userId
     *
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * EmailConfirmationWasSent messageId
     *
     * @return MessageId
     */
    public function messageId(): MessageId
    {
        return $this->messageId;
    }

    /**
     * EmailConfirmationWasSent message
     *
     * @return MessageContent
     */
    public function message(): MessageContent
    {
        return $this->message;
    }

    /**
     * @inheritDoc
     * @return array<string, mixed>
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
