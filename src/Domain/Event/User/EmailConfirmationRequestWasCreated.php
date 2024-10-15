<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\Event\User;

use App\Domain\User\EmailConfirmationRequest\EmailConfirmationRequestId;
use App\Domain\User\UserId;
use JsonSerializable;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * EmailConfirmationRequestWasCreated
 *
 * @package App\Domain\Event\User
 */
final class EmailConfirmationRequestWasCreated extends AbstractEvent implements Event, JsonSerializable
{


    /**
     * Creates a EmailConfirmationRequestWasCreated
     *
     * @param UserId $userId
     * @param EmailConfirmationRequestId $emailConfirmationRequestId
     * @param \DateTimeImmutable $expireDate
     */
    public function __construct(
        private readonly UserId $userId,
        private readonly EmailConfirmationRequestId $emailConfirmationRequestId,
        private readonly \DateTimeImmutable $expireDate
    ) {
        parent::__construct();
    }

    /**
     * EmailConfirmationRequestWasCreated userId
     *
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * EmailConfirmationRequestWasCreated emailConfirmationRequestId
     *
     * @return EmailConfirmationRequestId
     */
    public function emailConfirmationRequestId(): EmailConfirmationRequestId
    {
        return $this->emailConfirmationRequestId;
    }

    /**
     * EmailConfirmationRequestWasCreated expireDate
     *
     * @return \DateTimeImmutable
     */
    public function expireDate(): \DateTimeImmutable
    {
        return $this->expireDate;
    }

    /**
     * @inheritDoc
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
       return [
           'userId' => $this->userId,
           'emailConfirmationRequestId' => $this->emailConfirmationRequestId,
           'expireDate' => $this->expireDate,
       ];
    }
}
