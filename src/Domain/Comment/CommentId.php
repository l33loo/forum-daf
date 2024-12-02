<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\Comment;

use App\Domain\Common\EntityIdentifier;
use App\Domain\Common\EntityIdentifierMethods;

/**
 * CommentId
 *
 * @package App\Domain\Comment
 */
final class CommentId implements EntityIdentifier
{
    use EntityIdentifierMethods;
}
