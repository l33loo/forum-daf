<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Tag;

use App\Domain\Tag\TagRepository;
use PhpSpec\ObjectBehavior;

class VerifyTagHandlerSpec extends ObjectBehavior
{
    private $tagId;
    private $reason;

    function let(
        TagRepository $tags,

    ) {

    }
}