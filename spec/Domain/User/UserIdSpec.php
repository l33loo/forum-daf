<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\User;

use App\Domain\Exception\InvalidIdentifier;
use App\Domain\User\UserId;
use PhpSpec\ObjectBehavior;
use Ramsey\Uuid\Uuid;
use Stringable;

/**
 * UserIdSpec specs
 *
 * @package spec\App\Domain\User
 */
class UserIdSpec extends ObjectBehavior
{

    private $uniqueId;

    function let()
    {
        $this->uniqueId = Uuid::uuid4()->toString();
        $this->beConstructedWith($this->uniqueId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UserId::class);
    }

    function it_can_be_converted_to_string()
    {
        $this->shouldBeAnInstanceOf(Stringable::class);
        $this->__toString()->shouldBeLike($this->uniqueId);
    }

    function it_can_be_converted_to_json()
    {
        $this->shouldBeAnInstanceOf(\JsonSerializable::class);
        $this->jsonSerialize()->shouldBe($this->uniqueId);
    }

    function it_can_be_created_without_identifier()
    {
        $this->beConstructedWith();
        $this->__toString()->shouldMatch('#\b(uuid:){0,1}\s*([a-f0-9\\-]*){1}\s*#');
    }

    function it_throws_an_exception_if_identifier_is_invalid()
    {
        $this->beConstructedWith('invalid');
        $this->shouldThrow(InvalidIdentifier::class)
            ->duringInstantiation();
    }
}