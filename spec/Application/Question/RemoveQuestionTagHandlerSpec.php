<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Question;

use App\Application\Question\RemoveQuestionTagCommand;
use App\Application\Question\RemoveQuestionTagHandler;
use App\Domain\Exception\EntityNotFound;
use App\Domain\Question;
use App\Domain\Question\QuestionId;
use App\Domain\Question\QuestionRepository;
use App\Domain\Tag;
use App\Domain\Tag\TagRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slick\Event\EventDispatcher;

/**
 * RemoveQuestionTagHandlerSpec specs
 *
 * @package spec\App\Application\Question
 */
class RemoveQuestionTagHandlerSpec extends ObjectBehavior
{
    private $questionId;
    private $tag;

    function let(
        QuestionRepository $questions,
        TagRepository $tags,
        EventDispatcher $dispatcher,
        Question $question
    ) {
        $this->questionId = new QuestionId();
        $this->tag = new Tag('hello');
        $tags->withTagText($this->tag->tag())->willThrow(EntityNotFound::class);
        $questions->withId($this->questionId)->willReturn($question);
        $question->removeTag(Argument::type(Tag::class))->willReturn($question);

        $dispatcher->dispatchEventsFrom($question)->willReturn([]);

        $this->beConstructedWith($questions, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RemoveQuestionTagHandler::class);
    }

    function it_removes_question_tag(
        Question $question,
        EventDispatcher $dispatcher
    ) {
        $command = new RemoveQuestionTagCommand($this->questionId, $this->tag);
        $this->shouldNotThrow(EntityNotFound::class)->during('handle', [$command]);
        $this->handle($command)->shouldBe($question);
        $question->removeTag($this->tag)->shouldHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($question)->shouldHaveBeenCalled();
    }
}