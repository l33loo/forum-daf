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
 * UserAccountWasRemoved
 *
 * @package App\Domain\Event\User
 */
final class UserAccountWasRemoved extends AbstractEvent implements Event, JsonSerializable
{


    /**
     * Creates a UserAccountWasRemoved
     *
     * @param UserId $userId
     */
    public function __construct(private readonly UserId $userId)
    {
        parent::__construct();
    }

    /**
     * UserAccountWasRemoved userId
     *
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * @inheritDoc
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'userId' => $this->userId,
        ];
    }
}
