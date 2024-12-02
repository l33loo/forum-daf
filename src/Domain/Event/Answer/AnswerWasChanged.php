<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\Event\Answer;

use App\Domain\Answer\AnswerId;
use JsonSerializable;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * AnswerWasChanged
 *
 * @package App\Domain\Event\Answer
 */
final class AnswerWasChanged extends AbstractEvent implements Event, JsonSerializable
{


    public function __construct(private readonly AnswerId $answerId)
    {
        parent::__construct();
    }

    /**
     * AnswerWasChanged answerId
     *
     * @return AnswerId
     */
    public function answerId(): AnswerId
    {
        return $this->answerId;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'answerId' => $this->answerId
        ];
    }
}
