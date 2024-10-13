<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\User\Specification;

use App\Domain\Exception\EntityNotFound;
use App\Domain\User;
use App\Domain\User\Specification\NewUserSpecification;
use App\Domain\User\UserRepository;
use App\Domain\User\UserSpecification;
use PhpSpec\ObjectBehavior;

/**
 * NewUserSpecificationSpec specs
 *
 * @package spec\App\Domain\User\Specification
 */
class NewUserSpecificationSpec extends ObjectBehavior
{

    private $existingEmail;
    private $newEmail;
    private $userId;

    function let(UserRepository $users, User $user)
    {
        $this->existingEmail = new User\Email('johndoe@example.com');
        $this->newEmail = new User\Email('johndoe@example.org');
        $this->userId = new User\UserId();

        $users->withEmail($this->existingEmail)->willReturn($user);
        $users->withEmail($this->newEmail)->willThrow(EntityNotFound::class);

        $user->email()->willReturn($this->existingEmail);
        $user->userId()->willReturn($this->userId);

        $this->beConstructedWith($users);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(NewUserSpecification::class);
    }

    function its_a_user_specification()
    {
        $this->shouldImplement(UserSpecification::class);
    }

    function it_passes_when_there_are_no_users_with_provided_email_address()
    {
        $user = new User($this->newEmail);
        $this->isSatisfiedBy($user)->shouldBe(true);
    }

    function it_fails_when_there_a_user_with_provided_email_address_exist()
    {
        $user = new User($this->existingEmail);
        $this->isSatisfiedBy($user)->shouldBe(false);
    }

    function it_passes_when_there_a_user_with_provided_email_address_witch_is_himself(User $user)
    {
        $this->isSatisfiedBy($user)->shouldBe(true);
    }
}