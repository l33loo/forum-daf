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

/**
 * DeleteAnswerCommand
 *
 * @package App\Application\Answer
 */
final readonly class DeleteAnswerCommand
{
    public function __construct(private AnswerId $answerId)
    {
    }

    /**
     * DeleteAnswerCommand answerId
     *
     * @return AnswerId
     */
    public function answerId(): AnswerId
    {
        return $this->answerId;
    }
}
