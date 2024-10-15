<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Common\EmailMessage;

use App\Domain\Common\EmailMessage\MessageId;
use App\Domain\Common\EntityIdentifier;
use PhpSpec\ObjectBehavior;

/**
 * MessageIdSpec specs
 *
 * @package spec\App\Domain\Common\EmailMessage
 */
class MessageIdSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(MessageId::class);
    }

    function its_an_entity_identifier()
    {
        $this->shouldImplement(EntityIdentifier::class);
    }
}