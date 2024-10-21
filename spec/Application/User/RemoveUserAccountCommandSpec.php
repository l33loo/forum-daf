<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\User;

use App\Application\User\RemoveUserAccountCommand;
use App\Domain\User\UserId;
use PhpSpec\ObjectBehavior;

/**
 * RemoveUserAccountCommandSpec specs
 *
 * @package spec\App\Application\User
 */
class RemoveUserAccountCommandSpec extends ObjectBehavior
{

    private $userId;

    function let()
    {
        $this->userId = new UserId();
        $this->beConstructedWith($this->userId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RemoveUserAccountCommand::class);
    }

    function it_has_a_userId()
    {
        $this->userId()->shouldBe($this->userId);
    }
}