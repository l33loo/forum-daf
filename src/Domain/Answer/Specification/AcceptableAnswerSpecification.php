<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\Answer\Specification;

use App\Domain\ContentValidator;
use App\Domain\Answer;
use App\Domain\Answer\AnswerSpecification;

/**
 * AcceptableAnswerSpecification
 *
 * @package App\Domain\Answer\Specification
 */
class AcceptableAnswerSpecification implements AnswerSpecification
{

    private ?string $reason = null;

    public function __construct(private readonly ContentValidator $validator)
    {
    }


    public function isSatisfiedBy(Answer $answer): bool
    {
        if ($this->validator->validateContent($answer->body())) {
            return true;
        }

        $this->reason = $this->validator->reason();
        return false;
    }

    /**
     * AcceptableAnswerSpecification reason
     *
     * @return string|null
     */
    public function reason(): ?string
    {
        return $this->reason;
    }
}
