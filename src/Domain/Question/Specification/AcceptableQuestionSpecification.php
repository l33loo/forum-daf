<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\Question\Specification;

use App\Domain\ContentValidator;
use App\Domain\Question;
use App\Domain\Question\QuestionSpecification;

/**
 * AcceptableQuestionSpecification
 *
 * @package App\Domain\Question\Specification
 */
class AcceptableQuestionSpecification implements QuestionSpecification
{

    private ?string $reason = null;

    public function __construct(private readonly ContentValidator $validator)
    {
    }


    public function isSatisfiedBy(Question $question): bool
    {
        if ($this->validator->validateContent($question->body(), ['question' => $question->question()])) {
            return true;
        }

        $this->reason = $this->validator->reason();
        return false;
    }

    /**
     * AcceptableQuestionSpecification reason
     *
     * @return string|null
     */
    public function reason(): ?string
    {
        return $this->reason;
    }
}
