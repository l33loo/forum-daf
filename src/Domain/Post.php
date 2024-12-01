<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Event\Question\QuestionWasAccepted;
use App\Domain\Event\Question\QuestionWasPublished;
use App\Domain\Event\Question\QuestionWasRejected;
use App\Domain\Post\PostId;
use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\MappedSuperclass;
use Slick\Event\Domain\EventGeneratorMethods;
use Slick\Event\EventGenerator;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\Relationship;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\ResourceAttribute;

/**
 * Post
 *
 * @package App\Domain
 */
#[MappedSuperclass]
abstract class Post implements EventGenerator
{

    use EventGeneratorMethods;

    #[Column(type: 'PostId', unique: true)]
    private PostId $postId;

    #[Column(type: "boolean", options: ["default" => false])]
    private bool $published = false;

    #[Column(type: "text")]
    protected string $body;

    #[Column(type: "datetime_immutable", nullable: true)]
    private ?DateTimeImmutable $publishedOn = null;

    #[ManyToOne(targetEntity: User::class)]
    #[JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private User $author;

    #[Column(type: "boolean", options: ["default" => false])]
    private bool $accepted = false;

    #[Column(nullable: true)]
    private ?string $rejectReason = null;

    public function __construct(User $author, string $body)
    {
        $this->author = $author;
        $this->body = $body;
        $this->postId = new PostId();
    }

    /**
     * Post postId
     *
     * @return PostId
     */
    public function postId(): PostId
    {
        return $this->postId;
    }

    /**
     * Post published
     *
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->published;
    }

    /**
     * Post body
     *
     * @return string
     */
    public function body(): string
    {
        return $this->body;
    }

    /**
     * Post publishedOn
     *
     * @return null|DateTimeImmutable
     */
    public function publishedOn(): ?DateTimeImmutable
    {
        return $this->publishedOn;
    }

    /**
     * Post author
     *
     * @return User
     */
    public function author(): User
    {
        return $this->author;
    }

    /**
     * Returns whether this question is accepted or not.
     *
     * @return bool
     */
    public function isAccepted(): bool
    {
        return $this->accepted;
    }

    public function accept(): self
    {
        $this->accepted = true;
        return $this;
    }

    /**
     * Get the reason for rejection.
     *
     * @return string|null The reason for rejection, or null if not set
     */
    public function rejectReason(): ?string
    {
        return $this->rejectReason;
    }

    /**
     * Reject the question with the given reason.
     *
     * @param string $reason The reason for rejection
     * @return self This instance for a fluent interface
     */
    public function reject(string $reason): self
    {
        $this->rejectReason =$reason;
        $this->accepted = false;
        return $this;
    }

    public function publish(): self
    {
        $this->publishedOn = new DateTimeImmutable();
        $this->published = true;
        return $this;
    }
}
