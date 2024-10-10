<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\Event\User;

use App\Domain\User\UserId;
use JsonSerializable;
use SensitiveParameter;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * UserHasChangedPassword
 *
 * @package App\Domain\Event\User
 */
final class UserHasChangedPassword extends AbstractEvent implements Event, JsonSerializable
{


    /**
     * Creates a UserHasChangedPassword
     *
     * @param UserId $userId
     * @param string $passwordHash
     */
    public function __construct(
        private readonly UserId $userId,
        #[SensitiveParameter]
        private readonly string $passwordHash
    ) {
        parent::__construct();
    }

    /**
     * Returns the userId object associated with this entity
     *
     * @return UserId The userId object
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * Retrieve the password hash.
     *
     * @return string The password hash.
     */
    public function passwordHash(): string
    {
        return $this->passwordHash;
    }

    /**
     * @inheritDoc
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'userId' => $this->userId,
            'passwordHash' => $this->passwordHash,
        ];
    }
}
