<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Question;

use App\Domain\User\UserId;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\AsResourceObject;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\RelationshipIdentifier;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\ResourceAttribute;

/**
 * PostQuestionCommand
 *
 * @package App\Application\Question
 */
#[AsResourceObject(type: "questions")]
final readonly class PostQuestionCommand
{


    public function __construct(
        #[RelationshipIdentifier(name: 'author', className: UserId::class)]
        private UserId $userId,
        #[ResourceAttribute(required: true)]
        private string $question,
        #[ResourceAttribute(required: true)]
        private string $body,
    ) {
    }

    /**
     * PostQuestionCommand userId
     *
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * PostQuestionCommand question
     *
     * @return string
     */
    public function question(): string
    {
        return $this->question;
    }

    /**
     * PostQuestionCommand body
     *
     * @return string
     */
    public function body(): string
    {
        return $this->body;
    }
}
