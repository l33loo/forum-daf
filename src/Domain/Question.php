<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Event\Question\QuestionWasPost;
use App\Domain\Question\QuestionId;

/**
 * Question
 *
 * @package App\Domain
 */
class Question extends Post
{

    private QuestionId $questionId;

    public function __construct(User $user, private string $question, string $body)
    {
        $this->questionId = new QuestionId();
        parent::__construct($user, $body);

        $this->recordThat(new QuestionWasPost(
            $this->questionId,
            $user->userId(),
            $this->question,
            $body
        ));
    }

    /**
     * Question's question
     *
     * @return string
     */
    public function question(): string
    {
        return $this->question;
    }

    /**
     * Question questionId
     *
     * @return QuestionId
     */
    public function questionId(): QuestionId
    {
        return $this->questionId;
    }
}
