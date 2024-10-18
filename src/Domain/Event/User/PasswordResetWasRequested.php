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
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * PasswordResetWasRequested
 *
 * @package App\Domain\Event\User
 */
final class PasswordResetWasRequested extends AbstractEvent implements Event, JsonSerializable
{


    public function __construct(
        private readonly UserId $userId,
        private readonly string $token,
    ) {
        parent::__construct();
    }

    /**
     * PasswordResetWasRequested userId
     *
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * PasswordResetWasRequested token
     *
     * @return string
     */
    public function token(): string
    {
        return $this->token;
    }

    /**
     * @inheritDoc
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'token' => $this->token,
            'userId' => $this->userId
        ];
    }
}
