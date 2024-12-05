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
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\AsResourceObject;

#[AsResourceObject(type: "answers")]
final class ChangeAnswerCommand
{
    public function __construct(
        private AnswerId $answerId,
        private string $body
    ) {}

    public function answerId(): AnswerId
    {
        return $this->answerId;
    }

    public function body(): string
    {
        return $this->body;
    }
}