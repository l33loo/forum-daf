<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\User;

use App\Application\User\ConfirmUserEmailCommand;
use App\Domain\User\UserId;
use PhpSpec\ObjectBehavior;

/**
 * ConfirmUserEmailCommandSpec specs
 *
 * @package spec\App\Application\User
 */
class ConfirmUserEmailCommandSpec extends ObjectBehavior
{

    private $token;

    function let()
    {
        $this->token = "token";
        $this->beConstructedWith($this->token);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ConfirmUserEmailCommand::class);
    }

    function it_has_a_token()
    {
        $this->token()->shouldBe($this->token);
    }
}