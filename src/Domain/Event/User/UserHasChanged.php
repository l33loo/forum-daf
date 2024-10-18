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
 * UserHasChanged
 *
 * @package App\Domain\Event\User
 */
final class UserHasChanged extends AbstractEvent implements Event,JsonSerializable
{


    /**
     * Creates a UserHasChanged
     *
     * @param UserId $userId
     * @param string|null $name
     * @param Email $email
     */
    public function __construct(
        private readonly UserId $userId,
        private readonly string|null $name,
        private readonly Email $email
    ) {
        parent::__construct();
    }

    /**
     * UserHasChanged userId
     *
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * UserHasChanged name
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->name;
    }

    /**
     * UserHasChanged email
     *
     * @return Email
     */
    public function email(): Email
    {
        return $this->email;
    }


    /**
     * @inheritDoc
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'userId' => $this->userId,
            'name' => $this->name,
            'email' => $this->email
        ];
    }
}
