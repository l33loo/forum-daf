<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\User\Query\Model;

use App\Domain\User;
use App\Domain\User\Email;
use App\Domain\User\UserId;

/**
 * UserModel
 *
 * @package App\Application\User\Query\Model
 */
final readonly class UserModel
{

    private UserId $userId;
    private ?string $name;
    private Email $email;
    private bool $banned;
    private ?string $banReason;
    private bool $admin;

    public function __construct(array $data)
    {
        $this->userId = new UserId($data['userId']);
        $this->name = $data['name'];
        $this->email = new Email($data['email']);
        $this->banned = (bool) $data['banned'];
        $this->banReason = $data['banReason'];
        $roles = is_array($data['roles']) ? $data['roles'] : json_decode($data['roles'], true);

        $this->admin = in_array(User::ROLE_ADMIN, $roles);
    }

    /**
     * UserModel userId
     *
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * UserModel name
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->name;
    }

    /**
     * UserModel email
     *
     * @return Email
     */
    public function email(): Email
    {
        return $this->email;
    }

    /**
     * UserModel banned
     *
     * @return bool
     */
    public function banned(): bool
    {
        return $this->banned;
    }

    /**
     * UserModel banReason
     *
     * @return string|null
     */
    public function banReason(): ?string
    {
        return $this->banReason;
    }

    /**
     * UserModel admin
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->admin;
    }
}
