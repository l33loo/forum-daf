<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Answer;

use App\Application\Answer\ChangeAnswerCommand;
use App\Domain\Answer\AnswerId;
use PhpSpec\ObjectBehavior;

/**
 * ChangeAnswerCommandSpec specs
 *
 * @package spec\App\Application\Answer
 */
class ChangeAnswerCommandSpec extends ObjectBehavior
{
    private $answerId;
    private $body;

    function let()
    {
        $this->answerId = new AnswerId();
        $this->body = "Body...";

        $this->beConstructedWith($this->answerId, $this->body);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ChangeAnswerCommand::class);
    }

    function it_has_answer_id()
    {
        $this->answerId()->shouldBe($this->answerId);
    }

    function it_has_body()
    {
        $this->body()->shouldBe($this->body);
    }
}