<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain;

use App\Domain\Event\User\UserHasChangedPassword;
use App\Domain\Event\User\UserWasCreated;
use App\Domain\User;
use PhpSpec\ObjectBehavior;
use Slick\Event\EventGenerator;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * UserSpec specs
 *
 * @package spec\App\Domain
 */
class UserSpec extends ObjectBehavior
{

    private $name;
    private $email;

    function let()
    {
        $this->name = 'John Doe';
        $this->email = new User\Email('john.doe@example.com');
        $this->beConstructedWith($this->email, $this->name);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(User::class);
    }

    function it_has_a_user_id()
    {
        $this->userId()->shouldBeAnInstanceOf(User\UserId::class);
    }

    function it_has_a_name()
    {
        $this->name()->shouldBe($this->name);
    }

    function it_has_a_email()
    {
        $this->email()->shouldBe($this->email);
    }

    function its_a_security_user()
    {
        $this->shouldBeAnInstanceOf(UserInterface::class);
        $this->getUserIdentifier()->shouldBe((string) $this->email);
    }

    function it_can_erase_credentials()
    {
        $this->beConstructedWith($this->email, $this->name, 'pass');
        $this->shouldBeAnInstanceOf(PasswordAuthenticatedUserInterface::class);
        $this->getPassword()->shouldBe('pass');
        $this->eraseCredentials();
        $this->getPassword()->shouldBeNull();
    }

    function it_has_roles()
    {
        $this->getRoles()->shouldBe([User::ROLE_USER]);
    }

    function its_an_event_generator()
    {
        $this->shouldBeAnInstanceOf(EventGenerator::class);
        $events = $this->releaseEvents();
        $events->shouldHaveCount(1);
        $events[0]->shouldBeAnInstanceOf(UserWasCreated::class);
    }

    function it_can_change_its_password()
    {
        $this->releaseEvents();
        $this->withPassword('pass')->shouldBe($this->getWrappedObject());
        $this->getPassword()->shouldBe('pass');
        $events = $this->releaseEvents();
        $events->shouldHaveCount(1);
        $events[0]->shouldBeAnInstanceOf(UserHasChangedPassword::class);
    }
}