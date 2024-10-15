<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\User;

use App\Application\User\SendEmailConfirmationCommand;
use App\Domain\User\UserId;
use PhpSpec\ObjectBehavior;

/**
 * SendEmailConfirmationCommandSpec specs
 *
 * @package spec\App\Application\User
 */
class SendEmailConfirmationCommandSpec extends ObjectBehavior
{

    private $userId;

    function let()
    {
        $this->userId = new UserId();
        $this->beConstructedWith($this->userId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SendEmailConfirmationCommand::class);
    }

    function it_has_a_userId()
    {
        $this->userId()->shouldBe($this->userId);
    }

}