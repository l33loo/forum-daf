<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Answer;

use App\Domain\Answer\AnswerId;
use App\Domain\User;
use App\Domain\User\UserId;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\AsResourceObject;

#[AsResourceObject(type: "answers")]
final class VoteAnswerCommand
{
    public function __construct(
        private AnswerId $answerId,
        private UserId $userId,
        private bool $intention
    ) {}

    public function answerId(): AnswerId
    {
        return $this->answerId;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function intention(): bool
    {
        return $this->intention;
    }
}