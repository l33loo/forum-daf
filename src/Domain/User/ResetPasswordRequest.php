<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\User;
use DateTimeInterface;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestInterface;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestTrait;

/**
 * ResetPasswordRequest
 *
 * @package App\Domain\User
 */
#[Entity]
#[Table(name: 'reset_password_requests')]
class ResetPasswordRequest implements ResetPasswordRequestInterface
{

    use ResetPasswordRequestTrait;

    #[Id, Column(name: "id", type: 'integer'), GeneratedValue]
    private ?int $requestIdentifier = null;

    public function __construct(
        #[ManyToOne(targetEntity: User::class)]
        #[JoinColumn(name: "user_id")]
        private readonly User $user,
        DateTimeInterface $expiresAt,
        string $selector,
        string $hashedToken
    ) {
        $this->initialize($expiresAt, $selector, $hashedToken);
    }

    /**
     * ResetPasswordRequest requestIdentifier
     *
     * @return int|null
     */
    public function requestIdentifier(): ?int
    {
        return $this->requestIdentifier;
    }

    /**
     * @inheritDoc
     */
    public function getUser(): User
    {
        return $this->user;
    }
}
