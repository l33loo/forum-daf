<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain;

//use App\Domain\Event\Answer\AnswerHasChanged;
use App\Domain\Event\Answer\AnswerWasAccepted;
use App\Domain\Event\Answer\AnswerWasGiven;
//use App\Domain\Event\Answer\AnswerWasRejected;
//use App\Domain\Event\Answer\AnswerWasUnpublished;
use App\Domain\Answer\AnswerId;
use App\Domain\Event\Answer\AnswerWasPublished;
use App\Domain\Event\Answer\AnswerWasRejected;
use App\Domain\Event\Answer\AnswerWasUnpublished;
use App\Infrastructure\JsonApi\AnswerSchema;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\AsResourceObject;

/**
 * Answer
 *
 * @package App\Domain
 */
#[Entity]
#[Table(name: 'answers')]
#[AsResourceObject(schemaClass: AnswerSchema::class)]
class Answer extends Post
{

    #[Id]
    #[GeneratedValue(strategy: 'NONE')]
    #[Column(name: 'id', type: 'AnswerId')]
    private AnswerId $answerId;

    public function __construct(
        User $user,
        #[Column]
        string $body
    ) {
        $this->answerId = new AnswerId();

        parent::__construct($user, $body);

        $this->recordThat(new AnswerWasGiven(
            $this->answerId,
            $user->userId(),
            $body
        ));
    }

    /**
     * Answer answerId
     *
     * @return AnswerId
     */
    public function answerId(): AnswerId
    {
        return $this->answerId;
    }

    public function accept(): self
    {
        parent::accept();
        $this->recordThat(new AnswerWasAccepted($this->answerId));
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function reject(string $reason): self
    {
        parent::reject($reason);
        $this->recordThat(new AnswerWasRejected($this->answerId, $reason));
        return $this;
    }

    public function publish(): Answer
    {
        parent::publish();
        $this->recordThat(new AnswerWasPublished($this->answerId, $this->publishedOn()));
        return $this;
    }

    public function unpublish(): Answer
    {
        parent::unpublish();
        $this->recordThat(new AnswerWasUnpublished($this->answerId));
        return $this;
    }

//    public function change(string $body): self
//    {
//        $this->body = $body;
//        $this->recordThat(new AnswerHasChanged($this->answerId));
//
//        return $this;
//    }
}
