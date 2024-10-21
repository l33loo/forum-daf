<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain;

use App\Domain\Common\Equatable;
use App\Domain\Event\User\EmailConfirmationRequestWasCreated;
use App\Domain\Event\User\UserEmailHasChanged;
use App\Domain\Event\User\UserEmailWasConfirmed;
use App\Domain\Event\User\UserHasChanged;
use App\Domain\Event\User\UserHasChangedPassword;
use App\Domain\Event\User\UserHasRegistered;
use App\Domain\Event\User\UserWasCreated;
use App\Domain\Event\User\UserWasDemotedFromAdmin;
use App\Domain\Event\User\UserWasPromotedToAdmin;
use App\Domain\User;
use App\Domain\User\EmailConfirmationRequest;
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

    function it_can_be_created_as_a_registration()
    {
        $this->beConstructedThrough('register', [$this->email, $this->name, 'hashed_password']);
        $this->email()->shouldBe($this->email);
        $this->userId()->shouldBeAnInstanceOf(User\UserId::class);
        $this->name()->shouldBe($this->name);
        $this->getPassword()->shouldBe('hashed_password');
        $events = $this->releaseEvents();
        $events->shouldHaveCount(1);
        $events[0]->shouldBeAnInstanceOf(UserHasRegistered::class);
    }

    function it_can_create_email_confirmation_requests()
    {
        $this->releaseEvents();
        $request = $this->createEmailConfirmation("PT10M");
        $request->shouldBeAnInstanceOf(EmailConfirmationRequest::class);
        $events = $this->releaseEvents();
        $events->shouldHaveCount(1);
        $events[0]->shouldBeAnInstanceOf(EmailConfirmationRequestWasCreated::class);
    }

    function it_can_confirm_the_email_address()
    {
        $request = $this->createEmailConfirmation("PT10M");
        $this->isVerified()->shouldBe(false);
        $this->releaseEvents();
        $this->confirmEmail($request)->shouldBe($this->getWrappedObject());
        $this->isVerified()->shouldBe(true);
        $events = $this->releaseEvents();
        $events->shouldHaveCount(1);
        $events[0]->shouldBeAnInstanceOf(UserEmailWasConfirmed::class);
    }

    function it_can_be_compared()
    {
        $this->shouldBeAnInstanceOf(Equatable::class);
        $this->equals($this->getWrappedObject())->shouldBe(true);
        $this->equals(new User($this->email))->shouldBe(false);
    }

    function it_updates_user_name()
    {
        $name = "Jane doe";
        $this->releaseEvents();
        $this->update($name, $this->email)->shouldBe($this->getWrappedObject());
        $this->name()->shouldBe($name);
        $events = $this->releaseEvents();
        $events->shouldHaveCount(1);
        $events[0]->shouldBeAnInstanceOf(UserHasChanged::class);
    }

    function it_records_email_changes()
    {
        $name = "Jane doe";
        $this->releaseEvents();
        $updatedEmail = new User\Email('jane.doe@test.org');
        $this->update($name, $updatedEmail)->shouldBe($this->getWrappedObject());
        $this->name()->shouldBe($name);
        $events = $this->releaseEvents();
        $events->shouldHaveCount(2);
        $events[0]->shouldBeAnInstanceOf(UserHasChanged::class);
        $events[1]->shouldBeAnInstanceOf(UserEmailHasChanged::class);
    }

    function it_can_be_promoted_to_admin()
    {
        $this->releaseEvents();
        $this->promoteToAdmin()->shouldBe($this->getWrappedObject());
        $this->getRoles()->shouldContain(User::ROLE_ADMIN);
        $events = $this->releaseEvents();
        $events->shouldHaveCount(1);
        $events[0]->shouldBeAnInstanceOf(UserWasPromotedToAdmin::class);
    }

    function it_canbe_demoted_from_admin()
    {
        $this->releaseEvents();
        $this->demoteFromAdmin()->shouldBe($this->getWrappedObject());
        $this->getRoles()->shouldNotContain(User::ROLE_ADMIN);
        $events = $this->releaseEvents();
        $events->shouldHaveCount(1);
        $events[0]->shouldBeAnInstanceOf(UserWasDemotedFromAdmin::class);
    }
}