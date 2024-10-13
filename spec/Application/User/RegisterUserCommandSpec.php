<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\User;

use App\Application\User\RegisterUserCommand;
use App\Domain\User\Email;
use PhpSpec\ObjectBehavior;

/**
 * RegisterUserCommandSpec specs
 *
 * @package spec\App\Application\User
 */
class RegisterUserCommandSpec extends ObjectBehavior
{

    private $email;
    private $name;
    private $password;

    function let()
    {
        $this->email = new Email('john.doe@example.com');
        $this->name = 'John Doe';
        $this->password = 'clear_text_password';
        $this->beConstructedWith($this->email, $this->name, $this->password);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RegisterUserCommand::class);
    }

    function it_has_a_email()
    {
        $this->email()->shouldBe($this->email);
    }

    function it_has_a_name()
    {
        $this->name()->shouldBe($this->name);
    }

    function it_has_a_password()
    {
        $this->password()->shouldBe($this->password);
    }

    function it_can_be_created_without_name_and_password()
    {
        $this->beConstructedWith($this->email);
        $this->name()->shouldBeNull();
        $this->password()->shouldBeNull();
    }
}