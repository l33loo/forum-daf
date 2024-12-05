<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\Vote;

use App\Domain\Common\EntityIdentifier;
use App\Domain\Common\EntityIdentifierMethods;

/**
 * VoteId
 *
 * @package App\Domain\Vote
 */
final class VoteId implements EntityIdentifier
{
    use EntityIdentifierMethods;
}
