<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Event\User\UserWasBanned;
use App\Domain\User;
use Doctrine\ORM\Mapping\Column;

/**
 * BanUserMethods
 *
 * @package App\Domain\User
 */
trait BanUserMethods
{

    #[Column(type: "boolean", options: ['default' => false])]
    private bool $banned = false;

    #[Column(name: "ban_reason", nullable: true)]
    private ?string $banReason = null;

    /**
     * @return bool
     */
    public function isBanned(): bool
    {
        return $this->banned;
    }

    /**
     * Bans a user for a specific reason.
     *
     * @param string $reason The reason for banning the user
     * @return User|BanUserMethods Returns the updated object with user banned and reason stored
     */
    public function ban(string $reason): self
    {
        $this->banned = true;
        $this->banReason = $reason;
        $this->recordThat(new UserWasBanned($this->userId, $reason));
        return $this;
    }

    /**
     * Retrieves the reason for banning the user, if available.
     *
     * @return string|null The reason for banning the user, if set; otherwise null
     */
    public function banReason(): ?string
    {
        return $this->banReason;
    }
}
