<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\Event\User;

use App\Domain\User\Email;
use App\Domain\User\EmailConfirmationRequest\EmailConfirmationRequestId;
use JsonSerializable;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * UserEmailWasConfirmed
 *
 * @package App\Domain\Event\User
 */
final class UserEmailWasConfirmed extends AbstractEvent implements Event, JsonSerializable
{


    /**
     * Creates a UserEmailWasConfirmed
     *
     * @param Email $email
     * @param EmailConfirmationRequestId $emailConfirmationId
     */
    public function __construct(
        private readonly Email $email,
        private readonly EmailConfirmationRequestId $emailConfirmationId,
    ) {
        parent::__construct();
    }

    /**
     * UserEmailWasConfirmed email
     *
     * @return Email
     */
    public function email(): Email
    {
        return $this->email;
    }

    /**
     * UserEmailWasConfirmed emailConfirmationId
     *
     * @return EmailConfirmationRequestId
     */
    public function emailConfirmationId(): EmailConfirmationRequestId
    {
        return $this->emailConfirmationId;
    }

    /**
     * @inheritDoc
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'email' => $this->email,
            'emailConfirmationId' => $this->emailConfirmationId
        ];
    }
}
