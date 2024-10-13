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
use SensitiveParameter;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * UserHasRegistered
 *
 * @package App\Domain\Event\User
 */
final class UserHasRegistered extends AbstractEvent implements Event, JsonSerializable
{


    /**
     * Creates a UserHasRegistered
     *
     * @param UserId $userIdentifier
     * @param Email $email
     * @param string|null $name
     * @param string|null $hashedPassword
     */
    public function __construct(
        private readonly UserId $userIdentifier,
        private readonly Email $email,
        private readonly ?string $name = null,
        #[SensitiveParameter]
        private readonly ?string $hashedPassword = null
    ) {
        parent::__construct();
    }

    /**
     * UserHasRegistered userIdentifier
     *
     * @return UserId
     */
    public function userIdentifier(): UserId
    {
        return $this->userIdentifier;
    }

    /**
     * UserHasRegistered email
     *
     * @return Email
     */
    public function email(): Email
    {
        return $this->email;
    }

    /**
     * UserHasRegistered name
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->name;
    }

    /**
     * UserHasRegistered hashedPassword
     *
     * @return string|null
     */
    public function hashedPassword(): ?string
    {
        return $this->hashedPassword;
    }

    /**
     * @inheritDoc
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'userIdentifier' => $this->userIdentifier,
            'email' => $this->email,
            'name' => $this->name,
            'hashedPassword' => $this->hashedPassword
        ];
    }
}
