<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Question;

use App\Application\Question\PostQuestionCommand;
use App\Domain\User;
use PhpSpec\ObjectBehavior;

/**
 * PostQuestionCommandSpec specs
 *
 * @package spec\App\Application\Question
 */
class PostQuestionCommandSpec extends ObjectBehavior
{

    private $question;
    private $body;
    private $userId;

    function let()
    {
        $this->question = 'Why?';
        $this->body = 'What is...';
        $this->userId = new User\UserId();

        $this->beConstructedWith($this->userId, $this->question, $this->body);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PostQuestionCommand::class);
    }

    function it_has_a_userId()
    {
        $this->userId()->shouldBe($this->userId);
    }

    function it_has_a_question()
    {
        $this->question()->shouldBe($this->question);
    }

    function it_has_a_body()
    {
        $this->body()->shouldBe($this->body);
    }

}