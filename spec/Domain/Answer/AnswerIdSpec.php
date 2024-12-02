<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Answer;

use App\Domain\Answer\AnswerId;
use App\Domain\Common\EntityIdentifier;
use PhpSpec\ObjectBehavior;

/**
 * AnswerIdSpec specs
 *
 * @package spec\App\Domain\Answer
 */
class AnswerIdSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AnswerId::class);
    }

    function its_entity_identifier()
    {
        $this->shouldBeAnInstanceOf(EntityIdentifier::class);
    }
}