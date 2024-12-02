<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Answer;

use App\Application\Answer\PublishAnswerCommand;
use App\Domain\Answer\AnswerId;
use PhpSpec\ObjectBehavior;

/**
 * PublishAnswerCommandSpec specs
 *
 * @package spec\App\Application\Answer
 */
class PublishAnswerCommandSpec extends ObjectBehavior
{

    private $answerId;

    function let()
    {
        $this->answerId = new AnswerId();
        $this->beConstructedWith($this->answerId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PublishAnswerCommand::class);
    }

    function it_has_a_answerId()
    {
        $this->answerId()->shouldBe($this->answerId);
    }

}