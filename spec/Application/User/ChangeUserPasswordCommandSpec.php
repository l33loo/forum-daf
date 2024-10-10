<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\User;

use App\Application\User\ChangeUserPasswordCommand;
use App\Domain\User\UserId;
use PhpSpec\ObjectBehavior;

/**
 * ChangeUserPasswordSpec specs
 *
 * @package spec\App\Application\User
 */
class ChangeUserPasswordCommandSpec extends ObjectBehavior
{

    private $userId;
    private $password;

    function let()
    {
        $this->userId = new UserId();
        $this->password = 'some-pass';
        $this->beConstructedWith($this->userId, $this->password);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ChangeUserPasswordCommand::class);
    }

    function it_has_a_userId()
    {
        $this->userId()->shouldBe($this->userId);
    }

    function it_has_a_password()
    {
        $this->password()->shouldBe($this->password);
    }
}