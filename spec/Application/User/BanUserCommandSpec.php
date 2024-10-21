<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\User;

use App\Application\User\BanUserCommand;
use App\Domain\User\UserId;
use PhpSpec\ObjectBehavior;

/**
 * BanUserCommandSpec specs
 *
 * @package spec\App\Application\User
 */
class BanUserCommandSpec extends ObjectBehavior
{

    private $userId;
    private $reason;

    function let()
    {
        $this->userId = new UserId();
        $this->reason = 'Reason';
        $this->beConstructedWith($this->userId, $this->reason);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(BanUserCommand::class);
    }

    function it_has_a_userId()
    {
        $this->userId()->shouldBe($this->userId);
    }

    function it_has_a_reason()
    {
        $this->reason()->shouldBe($this->reason);
    }
}