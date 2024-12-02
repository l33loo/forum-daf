<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Answer;

use App\Application\Answer\GiveAnswerCommand;
use App\Domain\User;
use PhpSpec\ObjectBehavior;

/**
 * GiveAnswerCommandSpec specs
 *
 * @package spec\App\Application\Answer
 */
class GiveAnswerCommandSpec extends ObjectBehavior
{
    private $body;
    private $userId;

    function let()
    {
        $this->body = 'It is...';
        $this->userId = new User\UserId();

        $this->beConstructedWith($this->userId, $this->body);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(GiveAnswerCommand::class);
    }

    function it_has_a_userId()
    {
        $this->userId()->shouldBe($this->userId);
    }

    function it_has_a_body()
    {
        $this->body()->shouldBe($this->body);
    }

}