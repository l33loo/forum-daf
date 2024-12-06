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
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\RelationshipIdentifier;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\ResourceAttribute;

#[AsResourceObject(type: "votes")]
final readonly class VoteAnswerCommand
{
    public function __construct(
        #[RelationshipIdentifier(name: 'answer', className: AnswerId::class, required: true)]
        private AnswerId $answerId,
        #[RelationshipIdentifier(name: 'user', className: UserId::class, required: true)]
        private UserId $userId,
        #[ResourceAttribute(required: true)]
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