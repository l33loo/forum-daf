<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace App\Domain;

/**
 * Vote
 *
 * @package App\Domain
 */
class Vote
{
    

    public function __construct(
        private Answer $answer,
        private User $user,
        private int $intention
    ) {}

    public function answer(): Answer
    {
        return $this->answer;
    }

    public function user(): User
    {
        return $this->user;
    }

    public function intention(): int
    {
        return $this->intention;
    }
}