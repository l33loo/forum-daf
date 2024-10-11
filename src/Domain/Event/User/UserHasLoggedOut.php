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
 * UserHasLoggedOut
 *
 * @package App\Domain\Event\User
 */
final class UserHasLoggedOut extends AbstractEvent implements Event, JsonSerializable
{
    public function __construct(private readonly UserId $userIdentifier)
    {
        parent::__construct();
    }

    /**
     * @return UserId
     */
    public function userIdentifier(): UserId
    {
        return $this->userIdentifier;
    }

    /**
     * @inheritDoc
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return ['userIdentifier' => $this->userIdentifier];
    }
}
