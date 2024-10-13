<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\User;

use App\Domain\Common\Equatable;
use App\Domain\Exception\InvalidEmailAddress;
use App\Domain\User\Email;
use PhpSpec\ObjectBehavior;

/**
 * EmailSpec specs
 *
 * @package spec\App\Domain\User
 */
class EmailSpec extends ObjectBehavior
{

    private $emailAddress;

    function let()
    {
        $this->emailAddress = 'user@example.com';
        $this->beConstructedWith($this->emailAddress);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Email::class);
    }

    function it_can_be_converted_to_json()
    {
        $this->shouldBeAnInstanceOf(\JsonSerializable::class);
        $this->jsonSerialize()->shouldBe($this->emailAddress);
    }

    function it_can_be_converted_to_string()
    {
        $this->shouldBeAnInstanceOf(\Stringable::class);
        $this->__toString()->shouldBe($this->emailAddress);
    }

    function it_converts_all_characters_to_lower_case()
    {
        $emailAddress = 'USER@example.COM';
        $this->beConstructedWith($emailAddress);
        $this->__toString()->shouldBe(strtolower($emailAddress));
    }

    function it_throws_an_exception_when_email_is_not_valid()
    {
        $this->beConstructedWith('invalid-email');
        $this->shouldThrow(InvalidEmailAddress::class)
            ->duringInstantiation();
    }

    function it_is_equatable()
    {
        $this->shouldBeAnInstanceOf(Equatable::class);
        $emailAddress = new Email('user@example.org');
        $this->equals($emailAddress)->shouldBe(false);
        $this->equals(new Email($this->emailAddress))->shouldBe(true);
    }
}