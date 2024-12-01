<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Question;

use App\Application\Question\AddQuestionTagCommand;
use App\Application\Question\AddQuestionTagHandler;
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
 * AddQuestionTagHandlerSpec specs
 *
 * @package spec\App\Application\Question
 */
class AddQuestionTagHandlerSpec extends ObjectBehavior
{
    private $questionId;
    private $tag;

    function let(
        QuestionRepository $questions,
        TagRepository $tags,
        EventDispatcher $dispatcher,
        Question $question,
        Tag $tag
    ) {
        $this->questionId = new QuestionId();
        $this->tag = "hello";
        $tags->withTagText($this->tag)->willReturn($tag);
        $questions->withId($this->questionId)->willReturn($question);
        $question->addTag(Argument::type(Tag::class))->wilLReturn($question);

        $dispatcher->dispatchEventsFrom($question)->willReturn([]);

        $this->beConstructedWith($questions, $tags, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AddQuestionTagHandler::class);
    }

    function it_adds_question_tag(
        Question $question,
        EventDispatcher $dispatcher
    ) {
        $command = new AddQuestionTagCommand($this->questionId, $this->tag);
        $this->shouldNotThrow(EntityNotFound::class)->during('handle', [$command]);
        $this->handle($command)->shouldBe($question);
        $question->addTag(Argument::type(Tag::class))->shouldHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($question)->shouldHaveBeenCalled();
    }
}