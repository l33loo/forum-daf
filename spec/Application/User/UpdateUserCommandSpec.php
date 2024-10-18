<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\User;

use App\Application\User\UpdateUserCommand;
use App\Domain\User\Email;
use App\Domain\User\UserId;
use PhpSpec\ObjectBehavior;

/**
 * UpdateUserCommandSpec specs
 *
 * @package spec\App\Application\User
 */
class UpdateUserCommandSpec extends ObjectBehavior
{

    private $userId;
    private $name;
    private $email;

    function let()
    {
        $this->userId = new UserId();
        $this->name = "name";
        $this->email = new Email("john@doe.com");
        $this->beConstructedWith($this->userId, $this->name, $this->email);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UpdateUserCommand::class);
    }

    function it_has_a_userId()
    {
        $this->userId()->shouldBe($this->userId);
    }

    function it_has_a_name()
    {
        $this->name()->shouldBe($this->name);
    }

    function it_has_a_email()
    {
        $this->email()->shouldBe($this->email);
    }

}