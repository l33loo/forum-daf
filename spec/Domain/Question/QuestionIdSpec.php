<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Question;

use App\Domain\Common\EntityIdentifier;
use App\Domain\Common\Equatable;
use App\Domain\Exception\InvalidIdentifier;
use App\Domain\Question\QuestionId;
use PhpSpec\ObjectBehavior;
use Ramsey\Uuid\Uuid;
use Stringable;

/**
 * QuestionIdSpec specs
 *
 * @package spec\App\Domain\Question
 */
class QuestionIdSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(QuestionId::class);
    }

    function its_entity_identifier()
    {
        $this->shouldBeAnInstanceOf(EntityIdentifier::class);
    }
}