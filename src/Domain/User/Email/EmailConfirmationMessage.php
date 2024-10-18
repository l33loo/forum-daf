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
 *
 */
final class EmailConfirmationMessage implements EmailMessage
{

    private MessageId $messageId;

    private bool $update = false;

    /**
     * Creates a EmailConfirmationMessage
     *
     * @param User $user
     * @param string $subject
     * @param MessageContent $message
     */
    public function __construct(
        private readonly User $user,
        private readonly string $subject,
        private readonly MessageContent $message,
        private readonly ?string $validityExpirePeriod = "PT2H"
    ) {
        $this->messageId = new MessageId();
    }

    /**
     * Creates an EmailConfirmationMessage object from an update action
     *
     * @param User $user
     * @param string $subject
     * @param MessageContent $message
     * @param string|null $validityExpirePeriod
     * @return EmailConfirmationMessage
     */
    public static function createFromUpdate(
        User $user,
        string $subject,
        MessageContent $message,
        ?string $validityExpirePeriod = null
    ) {
        $emailConfirmationMessage = new EmailConfirmationMessage($user, $subject, $message, $validityExpirePeriod);
        $emailConfirmationMessage->update = true;

        return $emailConfirmationMessage;
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
            'token' => $this->user->createEmailConfirmation($this->validityExpirePeriod),
            'update' => $this->update,
        ];
    }

    /**
     * Determines if the entity instance represents an update operation.
     *
     * @return bool
     */
    public function isAnUpdate(): bool
    {
        return $this->update;
    }
}
