<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Post\PostId;
use Doctrine\Common\Collections\Collection;
use Slick\Event\Domain\EventGeneratorMethods;
use Slick\Event\EventGenerator;

/**
 * Post
 *
 * @package App\Domain
 */
abstract class Post implements EventGenerator
{

    use EventGeneratorMethods;

    private PostId $postId;

    private bool $published = false;

    private string $body;

    private \DateTimeImmutable $publishedOn;

    private User $author;

    public function __construct(User $author, string $body)
    {
        $this->author = $author;
        $this->body = $body;
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
    public function published(): bool
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
     * @return \DateTimeImmutable
     */
    public function publishedOn(): \DateTimeImmutable
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
}
