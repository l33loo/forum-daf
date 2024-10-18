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
 * ResetPasswordMessage
 *
 * @package App\Domain\User\Email
 */
final readonly class ResetPasswordMessage implements EmailMessage
{

    private MessageId $messageId;

    public function __construct(
        private User $user,
        private string $token,
        private string $subject,
        private MessageContent $message,
    ) {
        $this->messageId = new MessageId();
    }

    /**
     * ResetPasswordMessage messageId
     *
     * @return MessageId
     */
    public function messageId(): MessageId
    {
        return $this->messageId;
    }

    /**
     * ResetPasswordMessage user
     *
     * @return User
     */
    public function user(): User
    {
        return $this->user;
    }

    /**
     * ResetPasswordMessage token
     *
     * @return string
     */
    public function token(): string
    {
        return $this->token;
    }

    /**
     * ResetPasswordMessage subject
     *
     * @return string
     */
    public function subject(): string
    {
        return $this->subject;
    }

    /**
     * ResetPasswordMessage message
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
            'token' => $this->token
        ];
    }
}
