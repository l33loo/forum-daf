<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\User;

use App\Application\User\DemoteUserFromAdminCommand;
use App\Domain\User\UserId;
use PhpSpec\ObjectBehavior;

/**
 * DemoteUserFromAdminCommandSpec specs
 *
 * @package spec\App\Application\User
 */
class DemoteUserFromAdminCommandSpec extends ObjectBehavior
{
    private $userId;

    function let()
    {
        $this->userId = new UserId();
        $this->beConstructedWith($this->userId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DemoteUserFromAdminCommand::class);
    }

    function it_has_a_userId()
    {
        $this->userId()->shouldBe($this->userId);
    }

}