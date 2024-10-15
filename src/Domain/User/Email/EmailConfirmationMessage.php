<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\User\Email;


use App\Domain\Common\EmailMessage;
use App\Domain\Common\EmailMessage\MessageContent;
use App\Domain\Common\EmailMessage\MessageId;
use App\Domain\User;

/**
 * EmailConfirmationMessage
 *
 * @package App\Domain\User\Email
 */
final readonly class EmailConfirmationMessage implements EmailMessage
{

    private MessageId $messageId;

    /**
     * Creates a EmailConfirmationMessage
     *
     * @param User $user
     * @param string $subject
     * @param MessageContent $message
     */
    public function __construct(
        private User $user,
        private string $subject,
        private MessageContent $message,
        private ?string $validityExpirePeriod = "P2D"
    ) {
        $this->messageId = new MessageId();
    }

    /**
     * EmailConfirmationMessage messageId
     *
     * @return MessageId
     */
    public function messageId(): MessageId
    {
        return $this->messageId;
    }

    /**
     * EmailConfirmationMessage user
     *
     * @return User
     */
    public function user(): User
    {
        return $this->user;
    }

    /**
     * EmailConfirmationMessage subject
     *
     * @return string
     */
    public function subject(): string
    {
        return $this->subject;
    }

    /**
     * EmailConfirmationMessage message
     *
     * @return MessageContent
     */
    public function message(): MessageContent
    {
        return $this->message;
    }

    /**
     * @inheritDoc
     */
    public function recipients(): array
    {
        return [$this->user];
    }

    /**
     * @inheritDoc
     */
    public function context(): array
    {
        return [
            'subject' => $this->subject,
            'user' => $this->user,
            'token' => $this->user->createEmailConfirmation($this->validityExpirePeriod)
        ];
    }
}
