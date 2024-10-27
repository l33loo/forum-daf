<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\User;

use App\Domain\User\UserId;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\AsResourceObject;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\ResourceAttribute;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\ResourceIdentifier;

/**
 * BanUserCommand
 *
 * @package App\Application\User
 */
#[AsResourceObject(type: "users")]
final readonly class BanUserCommand
{


    public function __construct(
        #[ResourceIdentifier(className: UserId::class)]
        private UserId $userId,
        #[ResourceAttribute(required: true)]
        private string $reason
    ) {
    }

    /**
     * BanUserCommand userId
     *
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * BanUserCommand reason
     *
     * @return string
     */
    public function reason(): string
    {
        return $this->reason;
    }
}
