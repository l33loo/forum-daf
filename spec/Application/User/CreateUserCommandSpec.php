<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\User;

use App\Application\User\CreateUserCommand;
use App\Domain\User\Email;
use PhpSpec\ObjectBehavior;

/**
 * CreateUserCommandSpec specs
 *
 * @package spec\App\Application\User
 */
class CreateUserCommandSpec extends ObjectBehavior
{

    private $email;
    private $name;

    function let()
    {
        $this->email = new Email('example@example.com');
        $this->name = 'John Doe';
        $this->beConstructedWith($this->email, $this->name);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CreateUserCommand::class);
    }

    function it_has_an_email()
    {
        $this->email()->shouldBe($this->email);
    }

    function it_has_a_name()
    {
        $this->name()->shouldBe($this->name);
    }

    function it_can_be_created_without_name()
    {
        $this->beConstructedWith($this->email);
        $this->name()->shouldBeNull();
    }
}