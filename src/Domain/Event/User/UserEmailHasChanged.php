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
use App\Domain\User\UserId;
use JsonSerializable;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * UserEmailHasChanged
 *
 * @package App\Domain\Event\User
 */
final class UserEmailHasChanged extends AbstractEvent implements Event, JsonSerializable
{


    /**
     * Creates a UserEmailHasChanged
     *
     * @param UserId $userId
     * @param Email $oldEmail
     * @param Email $updatedEmail
     */
    public function __construct(
        private readonly UserId $userId,
        private readonly Email $oldEmail,
        private readonly Email $updatedEmail,
    ) {
        parent::__construct();
    }

    /**
     * UserEmailHasChanged userId
     *
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * UserEmailHasChanged oldEmail
     *
     * @return Email
     */
    public function oldEmail(): Email
    {
        return $this->oldEmail;
    }

    /**
     * UserEmailHasChanged updatedEmail
     *
     * @return Email
     */
    public function updatedEmail(): Email
    {
        return $this->updatedEmail;
    }


    /**
     * @inheritDoc
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'oldEmail' => $this->oldEmail,
            'updatedEmail' => $this->updatedEmail,
            'userId' => $this->userId
        ];
    }
}
