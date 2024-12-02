<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Answer;

use App\Application\Answer\VerifyAnswerCommand;
use App\Domain\Answer\AnswerId;
use PhpSpec\ObjectBehavior;

/**
 * VerifyAnswerCommandSpec specs
 *
 * @package spec\App\Application\Answer
 */
class VerifyAnswerCommandSpec extends ObjectBehavior
{

    private $answerId;

    function let()
    {
        $this->answerId = new AnswerId();
        $this->beConstructedWith($this->answerId);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(VerifyAnswerCommand::class);
    }

    function it_has_a_answerId()
    {
        $this->answerId()->shouldBe($this->answerId);
    }

}