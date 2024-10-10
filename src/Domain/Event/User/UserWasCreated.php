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
 * UserWasCreated
 *
 * @package App\Domain\Event\User
 */
final class UserWasCreated extends AbstractEvent implements Event, JsonSerializable
{


    /**
     * Creates a userWasCreated event
     *
     * @param UserId $userId The user ID.
     * @param Email $email The email address.
     * @param string|null $name The username (optional).
     */
    public function __construct(
        private readonly UserId $userId,
        private readonly Email $email,
        private readonly ?string $name = null
    ) {
        parent::__construct();
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function name(): ?string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'userId' => $this->userId,
            'email' => $this->email,
            'name' => $this->name,
        ];
    }
}
