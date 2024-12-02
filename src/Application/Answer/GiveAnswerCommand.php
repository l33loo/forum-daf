<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Answer;

use App\Domain\User\UserId;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\AsResourceObject;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\RelationshipIdentifier;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\ResourceAttribute;

/**
 * GiveAnswerCommand
 *
 * @package App\Application\Answer
 */
#[AsResourceObject(type: "answers")]
final readonly class GiveAnswerCommand
{


    public function __construct(
        #[RelationshipIdentifier(name: 'author', className: UserId::class)]
        private UserId $userId,
        #[ResourceAttribute(required: true)]
        private string $body,
    ) {
    }

    /**
     * GiveAnswerCommand userId
     *
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * GiveAnswerCommand answer
     *
     * @return string
     */
    public function answer(): string
    {
        return $this->answer;
    }

    /**
     * GiveAnswerCommand body
     *
     * @return string
     */
    public function body(): string
    {
        return $this->body;
    }
}
