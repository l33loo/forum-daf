<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\User\EmailConfirmationRequest;

use App\Domain\Common\EntityIdentifier;
use App\Domain\User\EmailConfirmationRequest\EmailConfirmationRequestId;
use PhpSpec\ObjectBehavior;

/**
 * EmailConfirmationRequestIdSpec specs
 *
 * @package spec\App\Domain\User\EmailConfirmationRequest
 */
class EmailConfirmationRequestIdSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(EmailConfirmationRequestId::class);
    }

    function its_an_entity_identifier()
    {
        $this->shouldBeAnInstanceOf(EntityIdentifier::class);
    }
}