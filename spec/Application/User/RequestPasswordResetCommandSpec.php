<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\User;

use App\Application\User\RequestPasswordResetCommand;
use App\Domain\User\Email;
use PhpSpec\ObjectBehavior;

/**
 * RequestPasswordResetCommandSpec specs
 *
 * @package spec\App\Application\User
 */
class RequestPasswordResetCommandSpec extends ObjectBehavior
{

    private $email;

    function let()
    {
        $this->email = new Email('john.doe@example.com');
        $this->beConstructedWith($this->email);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RequestPasswordResetCommand::class);
    }

    function it_has_email()
    {
        $this->email()->shouldReturn($this->email);
    }
}