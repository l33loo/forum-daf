<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\User\Query\Model;

use App\Application\User\Query\Model\UserModel;
use App\Domain\User;
use App\Domain\User\Email;
use App\Domain\User\UserId;
use PhpSpec\ObjectBehavior;

/**
 * UserModelSpec specs
 *
 * @package spec\App\Application\User\Query\Model
 */
class UserModelSpec extends ObjectBehavior
{

    private array $rows;

    function let()
    {
        $this->rows = require dirname(__FILE__) . '/user-data.php';
        $this->beConstructedWith($this->rows[2]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UserModel::class);
    }

    function it_has_an_id()
    {
        $this->userId()->equals(new UserId($this->rows[2]['userId']))->shouldReturn(true);
    }

    function it_has_a_name()
    {
        $this->name()->shouldBe($this->rows[2]['name']);
    }

    function it_has_a_email()
    {
        $this->email()->equals(new Email($this->rows[2]['email']))->shouldReturn(true);
    }

    function it_has_a_banned()
    {
        $this->banned()->shouldBe((bool) $this->rows[2]['banned']);
    }

    function it_has_a_banReason()
    {
        $this->banReason()->shouldBe($this->rows[2]['banReason']);
    }

    function it_has_a_isAdmin()
    {
        $this->isAdmin()->shouldBe(in_array(User::ROLE_ADMIN, $this->rows[2]['roles']));
    }
}