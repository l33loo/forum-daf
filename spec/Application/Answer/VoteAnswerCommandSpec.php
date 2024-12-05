<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Answer;

use App\Application\Answer\VoteAnswerCommand;
use App\Domain\Answer\AnswerId;
use App\Domain\User\UserId;
use PhpSpec\ObjectBehavior;

/**
 * VoteAnswerCommandSpec specs
 *
 * @package spec\App\Application\Answer
 */
class VoteAnswerCommandSpec extends ObjectBehavior
{
    private $answerId;
    private $userId;
    private $intention;

    function let() {
        $this->answerId = new AnswerId();
        $this->userId = new UserId();
        $this->intention = true;

        $this->beConstructedWith($this->answerId, $this->userId, $this->intention);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(VoteAnswerCommand::class);
    }

    function it_has_an_answerId()
    {
        $this->answerId()->shouldBe($this->answerId);
    }

    function it_has_a_userId()
    {
        $this->userId()->shouldBe($this->userId);
    }

    function it_has_an_intention()
    {
        $this->intention()->shouldBe($this->intention);
    }
}