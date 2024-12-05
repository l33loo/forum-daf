<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Vote;

use App\Domain\Common\EntityIdentifier;
use App\Domain\Vote\VoteId;
use PhpSpec\ObjectBehavior;

/**
 * VoteIdSpec specs
 *
 * @package spec\App\Domain\Vote
 */
class VoteIdSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(VoteId::class);
    }

    function its_entity_identifier()
    {
        $this->shouldBeAnInstanceOf(EntityIdentifier::class);
    }
}