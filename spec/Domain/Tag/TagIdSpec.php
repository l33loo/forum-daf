<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Tag;

use App\Domain\Common\EntityIdentifier;
use App\Domain\Tag\TagId;
use PhpSpec\ObjectBehavior;

/**
 * TagIdSpec specs
 *
 * @package spec\App\Domain\Tag
 */
class TagIdSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(TagId::class);
    }

    function its_entity_identifier()
    {
        $this->shouldBeAnInstanceOf(EntityIdentifier::class);
    }
}