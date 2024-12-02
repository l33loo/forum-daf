<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\Event\Comment;

use App\Domain\Comment\CommentId;
use JsonSerializable;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

/**
 * CommentWasChanged
 *
 * @package App\Domain\Event\Comment
 */
final class CommentWasChanged extends AbstractEvent implements Event, JsonSerializable
{


    public function __construct(private readonly CommentId $commentId)
    {
        parent::__construct();
    }

    /**
     * CommentWasChanged commentId
     *
     * @return CommentId
     */
    public function commentId(): CommentId
    {
        return $this->commentId;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'commentId' => $this->commentId
        ];
    }
}
