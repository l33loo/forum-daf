<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\Question;

use App\Domain\Question;

/**
 * QuestionSpecification
 *
 * @package App\Domain\Question
 */
interface QuestionSpecification
{

    public function isSatisfiedBy(Question $question): bool;
}
