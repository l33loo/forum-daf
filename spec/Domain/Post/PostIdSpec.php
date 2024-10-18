<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Post;

use App\Domain\Common\EntityIdentifier;
use App\Domain\Post\PostId;
use PhpSpec\ObjectBehavior;

/**
 * PostIdSpec specs
 *
 * @package spec\App\Domain\Post
 */
class PostIdSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PostId::class);
    }

    function its_a_entity_identifier()
    {
        $this->shouldBeAnInstanceOf(EntityIdentifier::class);
    }
}