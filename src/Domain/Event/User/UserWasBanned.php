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
 * UserWasBanned
 *
 * @package App\Domain\Event\User
 */
final class UserWasBanned extends AbstractEvent implements Event, JsonSerializable
{


    /**
     * Creates a UserWasBanned
     *
     * @param UserId $userId
     * @param string $reason
     */
    public function __construct(
        private readonly UserId $userId,
        private readonly string $reason
    ) {
        parent::__construct();
    }

    /**
     * UserWasBanned userId
     *
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * UserWasBanned reason
     *
     * @return string
     */
    public function reason(): string
    {
        return $this->reason;
    }

    /**
     * @inheritDoc
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'userId' => $this->userId,
            'reason' => $this->reason
        ];
    }
}
