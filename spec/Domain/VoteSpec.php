<?php

declare(strict_types=1);

namespace spec\App\Domain;

use App\Domain\Answer;
use App\Domain\Question;
use App\Domain\User;
use App\Domain\User\Email;
use App\Domain\Vote;
use App\Domain\Vote\VoteId;
use PhpSpec\ObjectBehavior;

class VoteSpec extends ObjectBehavior
{
    private $answer;
    private $user1;
    private $user2;
    private $user3;
    private $intention;
    private $question;

    public function let(): void
    {
        $this->user1 = new User(new Email("user1@email.com"));
        $this->user2 = new User(new Email("user2@email.com"));
        $this->user3 = new User(new Email("user3@email.com"));
        $this->question = new Question($this->user1, 'Question?', 'Body...');
        $this->answer = new Answer($this->user2,"Answer...", $this->question);
        $this->intention = true;

        $this->beConstructedWith($this->answer, $this->user3, $this->intention);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Vote::class);
    }

    public function it_has_a_voteId(): void
    {
        $this->voteId()->shouldHaveType(VoteId::class);
    }

    public function it_has_an_answer(): void
    {
        $this->answer()->shouldBe($this->answer);
    }

    public function it_has_a_user(): void
    {
        $this->user()->shouldBe($this->user3);
    }

    public function it_has_an_intention(): void
    {
        $this->intention()->shouldBe($this->intention);
    }
}