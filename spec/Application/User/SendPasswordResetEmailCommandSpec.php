<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\User;

use App\Application\User\SendPasswordResetEmailCommand;
use App\Domain\User\UserId;
use PhpSpec\ObjectBehavior;

/**
 * SendPasswordResetEmailCommandSpec specs
 *
 * @package spec\App\Application\User
 */
class SendPasswordResetEmailCommandSpec extends ObjectBehavior
{

    private $userId;
    private $token;

    function let()
    {
        $this->userId = new UserId();
        $this->token = "some-token";
        $this->beConstructedWith($this->userId, $this->token);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SendPasswordResetEmailCommand::class);
    }

    function it_has_a_userId()
    {
        $this->userId()->shouldBe($this->userId);
    }

    function it_has_a_token()
    {
        $this->token()->shouldBe($this->token);
    }

}