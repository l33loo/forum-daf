<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\User\Specification;

use App\Domain\User;
use App\Domain\User\Specification\CanVerifyEmailSpecification;
use App\Domain\User\UserRepository;
use PhpSpec\ObjectBehavior;

/**
 * CanVerifyEmailSpecificationSpec specs
 *
 * @package spec\App\Domain\User\Specification
 */
class CanVerifyEmailSpecificationSpec extends ObjectBehavior
{


    function let(
        UserRepository $users,
        User $user,
        User\EmailConfirmationRequest $request
    ) {
        $users->currentLoggedInUser()->willReturn($user);

        $request->isValid()->willReturn(true);
        $request->user()->willReturn($user);
        $user->confirmEmail($request)->willReturn($user);
        $user->equals($user)->willReturn(true);

        $this->beConstructedWith($users);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CanVerifyEmailSpecification::class);
    }

    function it_verifies_if_a_given_request_can_be_verified(User\EmailConfirmationRequest $request)
    {
        $this->isSatisfiedBy($request)->shouldReturn(true);
    }

    function it_fails_when_logged_in_use_is_not_the_request_owner(
        User $user,
        User\EmailConfirmationRequest $request
    ) {
        $user->equals($user)->willReturn(false);
        $this->isSatisfiedBy($request)->shouldReturn(false);
    }

    function it_fails_when_request_is_invalid(User\EmailConfirmationRequest $request)
    {
        $request->isValid()->willReturn(false);
        $this->isSatisfiedBy($request)->shouldReturn(false);
    }
}