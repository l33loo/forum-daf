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
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\AsResourceObject;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\ResourceIdentifier;

/**
 * RemoveQuestionCommand
 *
 * @package App\Application\Question
 */
#[AsResourceObject(type: "questions")]
final readonly class RemoveQuestionCommand
{
    public function __construct(
        #[ResourceIdentifier(className: QuestionId::class, required: true)]
        private QuestionId $questionId
    ) {
    }

    /**
     * RemoveQuestionCommand questionId
     *
     * @return QuestionId
     */
    public function questionId(): QuestionId
    {
        return $this->questionId;
    }
}
