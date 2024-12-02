<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Comment;

use App\Domain\Comment\CommentId;
use App\Domain\Common\EntityIdentifier;
use PhpSpec\ObjectBehavior;

/**
 * CommentIdSpec specs
 *
 * @package spec\App\Domain\Comment
 */
class CommentIdSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CommentId::class);
    }

    function its_entity_identifier()
    {
        $this->shouldBeAnInstanceOf(EntityIdentifier::class);
    }
}