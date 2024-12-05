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
use App\Domain\Tag;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\AsResourceObject;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\Relationship;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\ResourceAttribute;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\ResourceIdentifier;

/**
 * AddQuestionTagCommand
 *
 * @package App\Application\Question
 */
#[AsResourceObject(type: "questions")]
final class AddQuestionTagCommand
{
    public function __construct(
        #[ResourceIdentifier(className: QuestionId::class, required: true)]
        private readonly QuestionId $questionId,
//        #[Relationship(type: Relationship::TO_MANY)]
        #[ResourceAttribute(required: true)]
        private readonly string $tag
    ) {
    }

    public function questionId()
    {
        return $this->questionId;
    }

    public function tag()
    {
        return $this->tag;
    }
}