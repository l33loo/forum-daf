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
 * PublishAnswerCommand
 *
 * @package App\Application\Answer
 */
final readonly class PublishAnswerCommand
{


    public function __construct(private AnswerId $answerId)
    {
    }

    /**
     * PublishAnswerCommand answerId
     *
     * @return AnswerId
     */
    public function answerId(): AnswerId
    {
        return $this->answerId;
    }
}
