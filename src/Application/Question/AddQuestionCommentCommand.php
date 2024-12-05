<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Question;

use App\Domain\Question\QuestionId;
use App\Domain\Post\PostId;
use App\Domain\User\UserId;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\AsResourceObject;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\Relationship;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\RelationshipIdentifier;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\ResourceAttribute;

/**
 * AddQuestionCommentCommand
 *
 * @package App\Application\Question
 */
#[AsResourceObject(type: "comments")]
final readonly class AddQuestionCommentCommand
{
    public function __construct(
        private QuestionId $questionId,
        private PostId $postId,
        #[ResourceAttribute(required: true)]
        private string $body,
        #[RelationshipIdentifier(name: 'author', required: true)]
        private UserId $authorId
    ) {
    }

    public function questionId(): QuestionId
    {
        return $this->questionId;
    }

    public function postId(): PostId
    {
        return $this->postId;
    }

    public function body(): string
    {
        return $this->body;
    }

    public function authorId(): UserId
    {
        return $this->authorId;
    }
}